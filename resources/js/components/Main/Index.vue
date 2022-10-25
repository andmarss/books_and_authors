<template>
    <main>
        <div>
            <!-- Hero card -->
            <div class="relative">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="relative shadow-xl sm:rounded-2xl sm:overflow-hidden">
                        <div class="absolute inset-0">
                            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100" alt="People working on laptops">
                            <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
                        </div>
                        <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
                            <h1 class="text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                                <span class="block text-white">Продолжайте читать</span>
                            </h1>
                            <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">
                                Чтение - лучшее средство для получения идей.
                            </p>
                            <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                                <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
                                    <a href="#" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 sm:px-8">
                                        Начать
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="flex justify-between items-center max-w-7xl mx-auto px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8 items-center place-items-center">
                    <div class="w-1/4">
                        <input v-model="bookTitle" type="text" name="title" id="title" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Название книги">
                    </div>

                    <div class="w-1/4">
                        <dropdown v-model="author"
                                  searchable
                                  default-title="ФИО автора"

                                  :options="preparedAuthors"
                                  :loading="searchAuthors"
                                  :clear-search-on-close="false"

                                  @search="getAuthors"
                                  @clear="clearAuthors"
                        />
                    </div>

                    <div class="w-1/4">
                        <dropdown v-model="genre" :options="preparedGenres" default-title="Жанр" />
                    </div>

                    <div class="w-1/6 text-right">
                        <button @click.prevent="getBooks" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Искать
                        </button>
                    </div>
                </div>
            </div>

            <books>
                <template v-slot:empty>
                    <div class="text-center">
                        <span>
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <h3 class="mt-2 text-md font-medium text-gray-900">Пусто</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            По вашему запросу ничего не найдено, или вы еще ничего не искали =)
                        </p>
                    </div>
                </template>
            </books>

        </div>

        <!-- More main page content here... -->
    </main>
</template>

<script>
import Dropdown from '@components/Dropdown/Index.vue';
import Books from '@components/Books/Index.vue';
import GlobalMixin from '@js/mixins/global';
import {debounce} from 'lodash';

export default {
    name: "Main",
    mixins: [GlobalMixin],
    data() {
        return {
            bookTitle: '',
            backdoor: 0,
            genre: null,
            author: null,
            searchAuthors: false
        };
    },
    methods: {
        getAuthors: debounce(function (author = '') {
            this.searchAuthors = true;

            if (author.length) {
                this.$http.get(this.route('authors.index') + '?name=' + author).then(({data}) => {
                    this.$store.dispatch('updateAuthors', data.data);
                })
                    .catch(error => {
                        console.log(error);
                        this.$store.dispatch('updateAuthors', []);
                    }).then(() => {
                        this.searchAuthors = false;
                    });
            } else {
                this.$store.dispatch('updateAuthors', []);
                this.searchAuthors = false;
            }
        }, 500),
        clearAuthors() {
            this.$store.dispatch('updateAuthors', []);
        },
        getGenres() {
            return this.$http.get(this.route('categories.index')).then(({data}) => {
                    this.$store.dispatch('updateGenres', data.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getBooks() {
            let query = {
                title: this.bookTitle || null,
                category_id: this.genre?.id,
                author_id: this.author?.id
            };

            return this.$http.get(this.route('books.index') + this.objectToQueryString(query)).then(({data}) => {
                console.log('books', data.data, data.total);

                this.$store.dispatch('updateBooks', {
                    books: data.data,
                    total: data.total
                });
            }).catch(error => {
                console.log(error);
            });
        },
        load(){
            this.getGenres();
            this.getBooks();
        },
    },
    mounted() {
        this.load();
    },
    computed: {
        preparedAuthors() {
            return this.authors.map((author) => {
                return {
                    id: author.id,
                    title: author.full_name,
                    badge: author.books_count
                }
            });
        },
        preparedGenres() {
            return this.genres.map((genre) => {
                return {
                    id: genre.id,
                    title: genre.name
                }
            });
        },
        preparedBooks() {
            return this.books || [];
        }
    },
    components: {
        'dropdown' : Dropdown,
        'books' : Books
    }
}
</script>

<style scoped>

</style>

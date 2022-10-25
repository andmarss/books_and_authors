<template>
    <main class="flex-1">
        <div class="py-8 xl:py-10">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 xl:max-w-5xl xl:grid xl:grid-cols-3">
                <div class="xl:col-span-2 xl:pr-8 xl:border-r xl:border-gray-200">
                    <div>
                        <div>
                            <div class="md:flex md:items-center md:justify-between md:space-x-4 xl:border-b xl:pb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ bookTitle }}</h1>
                                    <p class="flex mt-2 text-sm text-gray-500">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="block pl-4 text-gray-900 text-sm font-medium">Последние изменения: <time :datetime="bookDateUpdatedDateTime">{{bookDateUpdated}}</time></span>
                                    </p>
                                </div>
                                <div class="mt-4 flex space-x-3 md:mt-0">
                                    <button v-if="user && book.author_id === user.id" type="button" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                        <!-- Heroicon name: solid/pencil -->
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                        <!-- Heroicon name: solid/bell -->
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                        </svg>
                                        <span>Subscribe</span>
                                    </button>
                                </div>
                            </div>
                            <aside class="mt-8 xl:hidden">
                                <h2 class="sr-only">Details</h2>
                                <div class="space-y-5">
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/lock-open -->
                                        <svg v-if="bookIsCancelled" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                                        </svg>

                                        <svg v-if="bookIsFinished" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M4.5 10.5H18V15H4.5v-4.5zM3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                                        </svg>

                                        <svg v-if="bookIsInProgress" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M4.5 10.5h6.75V15H4.5v-4.5zM3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                                        </svg>
                                        <span :class="[bookIsCancelled ? 'text-red-900' : '', bookIsFinished ? 'text-green-700' : '', bookIsInProgress ? 'text-green-500' : '']" class="text-sm font-medium">Статус : {{ bookStatusTitle }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-900 text-sm font-medium">Начата <time :datetime="bookDateCreatedDateTime">{{bookDateCreated}}</time></span>
                                    </div>
                                </div>
                                <div class="mt-6 border-t border-b border-gray-200 py-6 space-y-8">
                                    <div>
                                        <h2 class="text-sm font-medium text-gray-500">Автор</h2>
                                        <ul role="list" class="mt-3 space-y-3">
                                            <li class="flex justify-start">
                                                <a href="#" class="flex items-center space-x-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ bookAuthorFullName }}</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h2 class="text-sm font-medium text-gray-500">Жанр</h2>
                                        <ul role="list" class="mt-2 leading-8">
                                            <li class="inline">
                                                <a href="#" class="relative inline-flex items-center rounded-full border border-gray-300 px-3 py-0.5">
                                                    <div class="absolute flex-shrink-0 flex items-center justify-center">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                                    </div>
                                                    <div class="ml-3.5 text-sm font-medium text-gray-900">
                                                        {{ bookGenreName }}
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                            <div class="py-3 xl:pt-6 xl:pb-0">
                                <h2 class="sr-only">Description</h2>
                                <div class="prose max-w-none" v-html="book.description"></div>
                            </div>
                            <div class="py-3 xl:pt-6 xl:pb-0">
                                <h2 class="sr-only">Text</h2>
                                <div class="prose max-w-none" v-html="book.text"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="hidden xl:block xl:pl-8">
                    <h2 class="sr-only">Details</h2>
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2">
                            <svg v-if="bookIsCancelled" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                            </svg>

                            <svg v-if="bookIsFinished" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M4.5 10.5H18V15H4.5v-4.5zM3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                            </svg>

                            <svg v-if="bookIsInProgress" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M4.5 10.5h6.75V15H4.5v-4.5zM3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                            </svg>

                            <span :class="[bookIsCancelled ? 'text-red-900' : '', bookIsFinished ? 'text-green-700' : '', bookIsInProgress ? 'text-green-500' : '']" class="text-sm font-medium">Статус : {{ bookStatusTitle }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Heroicon name: solid/calendar -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-900 text-sm font-medium">Начата <time :datetime="bookDateCreatedDateTime">{{ bookDateCreated }}</time></span>
                        </div>
                    </div>
                    <div class="mt-6 border-t border-gray-200 py-6 space-y-8">
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Автор</h2>
                            <ul role="list" class="mt-3 space-y-3">
                                <li class="flex justify-start">
                                    <a href="#" class="flex items-center space-x-3">
                                        <div class="text-sm font-medium text-gray-900">{{ bookAuthorFullName }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Жанр</h2>
                            <ul role="list" class="mt-2 leading-8">
                                <li class="inline">
                                    <a href="#" class="relative inline-flex items-center rounded-full border border-gray-300 px-3 py-0.5">
                                        <div class="absolute flex-shrink-0 flex items-center justify-center">
                                            <span class="h-1.5 w-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                        </div>
                                        <div class="ml-3.5 text-sm font-medium text-gray-900">{{ bookGenreName }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</template>

<script>
import GlobalMixin from '@js/mixins/global';

export default {
    name: "Show",
    mixins: [GlobalMixin],
    props: {
        id: Number
    },
    data() {
        return {
            book: {},
            defaultBook: {
                title: '',
                text: '',
                author_id: 0,
                author: {},
                category_id: 0,
                category: {},
                status: 0,
                created_at: '',
                updated_at: '',

                is_cancelled: false,
                is_finished: false,
                is_in_progress: false,

                status_title: ''
            }
        };
    },

    methods: {
        getBook() {
            this.$http.get(this.route('books.show', this.id))
                .then(response => {
                    this.book = response.data.data || this.defaultBook;
                })
                .catch(error => {
                    console.log(error);
                    this.book = this.defaultBook;
                });
        }
    },

    mounted() {
        this.getBook();
    },

    computed: {
        bookGenreName() {
            return this.book?.category?.name || '';
        },
        bookAuthorFullName() {
            return this.book?.author?.full_name || '';
        },
        bookDateCreated() {
            return this.$moment(this.book?.created_at || Date.now()).format('LL');
        },
        bookDateCreatedDateTime() {
            return this.$moment(this.book?.created_at || Date.now()).format('Y-M-D');
        },
        bookDateUpdated() {
            return this.$moment(this.book?.updated_at || Date.now()).fromNow();
        },
        bookDateUpdatedDateTime() {
            return this.$moment(this.book?.updated_at || Date.now()).format('Y-M-D');
        },
        bookIsCancelled() {
            return this.book?.is_cancelled;
        },
        bookIsFinished() {
            return this.book?.is_finished;
        },
        bookIsInProgress() {
            return this.book?.is_in_progress;
        },
        bookStatusTitle() {
            return this.book?.status_title || '';
        },
        bookTitle() {
            return this.book?.title || '';
        },
    }
}
</script>

<style scoped>

</style>

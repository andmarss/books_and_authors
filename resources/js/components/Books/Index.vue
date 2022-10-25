<template>
    <div>
        <section aria-labelledby="products-heading" class="max-w-2xl mx-auto pt-12 pb-12 px-4 sm:pt-10 sm:pb-10 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 id="products-heading" class="sr-only">Книги</h2>

            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8" v-if="books.length">
                <router-link exact tag="a" v-for="book in books" :key="book.id" :to="{ name: 'books.show', params: {id: book.id} }" class="group cursor-pointer">
                    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                        <img :src="book.image" :alt="book.title" class="w-full h-full object-center object-cover group-hover:opacity-75">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">
                        Автор: {{ book.author.full_name }}
                    </h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">
                        {{ book.title }}
                    </p>
                </router-link>
            </div>

            <slot name="empty" v-if="!books.length"></slot>
        </section>

        <div class="pb-12 sm:pb-10">
            <pagination :per-page="per_page" :total="booksCount" :page="page" v-if="books.length" pagination-style="links" />
        </div>
    </div>
</template>

<script>
import Pagination from '@components/Pagination/Index.vue';

export default {
    name: "Books.vue",
    data() {
        return {
            page: 1,
            per_page: 9,
            order_by: 'id',
            order: 'desc'
        };
    },
    computed: {
        books() {
            return this.$store.getters.books;
        },
        booksCount() {
            return this.$store.getters.booksCount;
        }
    },
    components: {
        pagination : Pagination
    },
}
</script>

<style scoped>

</style>

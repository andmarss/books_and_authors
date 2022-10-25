<template>
    <div>
        <nav aria-label="Pagination" class="max-w-7xl mx-auto px-4 mt-6 flex justify-between text-sm font-medium text-gray-700 sm:px-6 lg:px-8" v-if="isLinks">
            <div class="min-w-0 flex-1">
                <button :disabled="!hasFirst" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25" :class="[hasPrev ? 'text-primary dim' : 'text-80 opacity-50']" @click.prevent="changePage(prevPage)" v-html="prev"></button>
            </div>
            <div class="hidden space-x-2 sm:flex">
                <!-- Current: "border-indigo-600 ring-1 ring-indigo-600", Default: "border-gray-300" -->
                <button v-if="hasFirst" @click.prevent="changePage(1)" :class="[hasFirst ? 'text-primary dim' : 'text-80 opacity-50']"  class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                    1
                </button>
                <button v-if="hasFirst && (current - range) > 2" :class="hasFirst && (current - range) > 2 ? 'text-primary dim' : 'text-80 opacity-50'" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                    ...
                </button>
                <button v-for="(page, index) in pages" :class="[page === current ? 'text-80 opacity-50' : 'text-primary dim']" :disabled="page === current" :key="index" @click.prevent="changePage(page)" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                    {{ page }}
                </button>
                <button :class="[hasLast && (current + range + 1) < totalPages ? 'text-primary dim' : 'text-80 opacity-50']" v-if="hasLast && (current + range + 1) < totalPages" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                    ...
                </button>
                <button :class="[hasLast && (current + range + 1) < totalPages ? 'text-primary dim' : 'text-80 opacity-50']" :disabled="current === totalPages" v-if="hasLast" @click.prevent="changePage(totalPages)" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25">
                    {{totalPages}}
                </button>
            </div>
            <div class="min-w-0 flex-1 flex justify-end">
                <button :disabled="!hasNext" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25" :class="[hasNext ? 'text-primary dim' : 'text-80 opacity-50']"  @click.prevent="changePage(nextPage)" v-html="next"></button>
            </div>
        </nav>
        <nav class="max-w-2xl mx-auto lg:max-w-7xl lg:px-8 flex justify-between items-center" v-if="isDefault">
            <button :disabled="!hasPrev" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25" :class="[hasPrev ? 'text-primary dim' : 'text-80 opacity-50']" @click.prevent="changePage(prevPage)" v-html="prev"></button>
            <span class="text-sm text-80 px-4">
                {{totalText}}
            </span>
            <button :disabled="!hasNext" class="inline-flex items-center px-4 h-10 border border-gray-300 rounded-md bg-white hover:bg-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-offset-1 focus:ring-offset-indigo-600 focus:ring-indigo-600 focus:ring-opacity-25" :class="[hasNext ? 'text-primary dim' : 'text-80 opacity-50']"  @click.prevent="changePage(nextPage)" v-html="next"></button>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        perPage: {
            type: Number,
            required: true
        },
        total: {
            type: Number,
            default: 0,
            required: true
        },
        range: {
            type: Number,
            default: 2
        },
        prev: {
            type: String,
            default: '&#171;'
        },
        next: {
            type: String,
            default: '&#187;'
        },
        roundedTop: {
            type: Boolean,
            default: false,
        },
        roundedBottom: {
            type: Boolean,
            default: false
        },
        paginationStyle: {
            type: String,
            default: 'default'
        },
        page: {
            type: Number,
            default: 1,
            required: true
        }
    },
    data(){
        return {
            styles: ['default', 'links'],
            defaultStyle: 'default',
            current: 1
        }
    },
    mounted(){
        if (this.styles.includes(this.paginationStyle)) {
            this.defaultStyle = this.paginationStyle;
        }

        this.current = this.page > 0 ? this.page : 1;
    },
    methods: {
        /**
         * Изменяет номер страницы
         * @param page
         */
        changePage(page){
            this.current = page;
            this.$emit('pageChanged', page);
        }
    },
    computed: {
        isDefault(){
            return this.defaultStyle === 'default' || (!this.isLinks && this.defaultStyle !== 'default');
        },
        isLinks(){
            return this.defaultStyle === 'links';
        },
        /**
         * Возвращает номер следующей страницы
         * @return {number}
         */
        nextPage(){
            return parseInt(this.current) + 1
        },
        /**
         * Возвращает номер предыдущей страницы
         * @return {number}
         */
        prevPage(){
            return parseInt(this.current) - 1
        },
        /**
         * Возвращает общее количество страниц
         * @return {number}
         */
        totalPages(){
            return this.total ? Math.ceil(this.total / this.perPage) : 0;
        },
        /**
         * возвращает ранжировку чисел перед текущей страницей
         * @return {number}
         */
        rangeStart(){
            let start = parseInt(this.current) - this.range;

            return start > 0 ? start : 1
        },
        /**
         * Возвращает ранжировку чисел после текущей страницы
         * @return {default.computed.totalPages|(function(): number)}
         */
        rangeEnd(){
            let end = parseInt(this.current) + this.range;

            return end < this.totalPages ? end : this.totalPages
        },
        /**
         *
         **/
        hasFirst() {
            return this.rangeStart !== 1;
        },
        /**
         *
         **/
        hasLast() {
            return this.rangeEnd < this.totalPages;
        },
        /**
         * Возвращает массив чисел для отображения кнопок пагинации
         * @return {Array}
         */
        pages(){
            let pages = [];

            for(let i = this.rangeStart; i <= this.rangeEnd; i++) {
                pages.push(i);
            }

            return pages;
        },
        /**
         * Возвращает true, если у текущей страницы есть предыдущая страница
         * Иначе - false
         * @return {boolean}
         */
        hasPrev(){
            return parseInt(this.current) > 1;
        },
        /**
         * Возвращает true, если у текущей страницы есть следующая страница
         * Иначе - false
         * @return {boolean}
         */
        hasNext(){
            return parseInt(this.current) < this.totalPages
        },

        totalText(){
            let from = ((this.current - 1) * this.perPage) + 1;
            let to = (this.current * this.perPage);

            let of = this.total;
            let totalPages = this.totalPages;

            if (to > of) {
                to = of;
            }

            from = Number(from).toLocaleString().replace(/\s+/g, ',');
            to = Number(to).toLocaleString().replace(/\s+/g, ',');
            of = Number(of).toLocaleString().replace(/\s+/g, ',');
            totalPages = Number(totalPages).toLocaleString().replace(/\s+/g, ',');

            return `${from}-${to} из ${of} (всего страниц: ${totalPages})`;
        }
    }
}
</script>

<style scoped>

</style>

import MainCard from './components/Main/Index.vue';
import Books from './components/Books/Main.vue';
import Book from './components/Books/Show.vue';

export default [
    {
        name: 'authors.index',
        path: '/',
        component: MainCard,
        meta: {title: 'Self Publishing'}
    },
    {
        name: 'books.index',
        path: '/books/',
        component: Books,
        meta: {title: 'Список книг'}
    },
    {
        name: 'books.show',
        path: '/books/:id',
        props: route => {
            return {
                id: route.params.id,
            };
        },
        component: Book
    }
];

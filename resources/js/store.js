import Vue from 'vue';
import Vuex from 'vuex';
import GlobalMixin from '@js/mixins/global.js';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        books_count: 0,
        books: [],
        authors: [],
        genres: [],
        filters: []
    },
    mutations: {
        setUser(state, user) {
            console.log('store set user', user);
            state.user = user;
        },
        setBooks(state, {books, total}) {
            state.books = books;
            state.books_count = total;
        },
        setAuthors(state, authors) {
            state.authors = authors;
        },
        setGenres(state, genres) {
            state.genres = genres;
        }
    },
    actions: {
        async toggle({commit}, visible) {
            commit('toggleVisibility', visible);
        },
        async load({commit}) {
            if (localStorage.getItem('token')) {
                try {
                    let { data } = await axios.get(GlobalMixin.methods.route('user'), {
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`
                        }
                    });

                    if (data?.data) {
                        commit('setUser', data.data);
                    }
                } catch (e) {
                    localStorage.removeItem('token');
                }
            }
        },
        async loadBooks({commit}) {
            let { data } = await axios.get(GlobalMixin.methods.route('books.index'));

            if (data.books) {
                commit('setBooks', data.books, data.books_count);
            }
        },

        async loadAuthors({commit}) {
            let { data } = await axios.get(GlobalMixin.methods.route('authors.index'));

            if (data.authors) {
                commit('setAuthors', data.authors);
            }
        },

        async loadGenres({commit}) {
            let { data } = await axios.get(GlobalMixin.methods.route('categories.index'));

            if (data.genres) {
                commit('setGenres', data.genres);
            }
        },

        async updateUser({commit}, user) {
            commit('setUser', user);
        },

        async updateBooks({commit}, data) {
            commit('setBooks', data);
        },

        async updateAuthors({commit}, authors) {
            commit('setAuthors', authors);
        },

        async updateGenres({commit}, genres) {
            commit('setGenres', genres);
        }
    },
    getters: {
        user(state) {
            return state.user;
        },
        books(state) {
            return state.books;
        },
        booksCount(state) {
            return state.books_count;
        },
        genres(state) {
            return state.genres;
        },
        authors(state) {
            return state.authors;
        }
    }
});

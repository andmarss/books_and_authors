require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import moment from 'moment';
import 'moment/locale/ru';
import PortalVue from 'portal-vue';
import store from './store';

window.Vue = Vue;

Vue.filter('formatDate', function (date, format = '', fromFormat = '') {

    if (!date) return '—';

    if (format) {
        return moment(date, fromFormat ? fromFormat : '').format(format);
    } else {
        date = moment(date, fromFormat ? fromFormat : '');
        return `${date.format('DD-MM-YYYY HH:mm:ss')}`;
    }
});

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.eventSetDrag = function () {
            el.setAttribute('data-dragging', 'yes');
        }
        el.eventClearDrag = function () {
            el.removeAttribute('data-dragging');
        }
        el.eventOnClick = function (event) {
            var dragging = el.getAttribute('data-dragging');
            if (!(el == event.target || el.contains(event.target)) && !dragging) {
                vnode.context[binding.expression](event);
            }
        };
        document.addEventListener('touchstart', el.eventClearDrag);
        document.addEventListener('touchmove', el.eventSetDrag);
        document.addEventListener('click', el.eventOnClick);
        document.addEventListener('touchend', el.eventOnClick);
    }, unbind: function (el) {
        document.removeEventListener('touchstart', el.eventClearDrag);
        document.removeEventListener('touchmove', el.eventSetDrag);
        document.removeEventListener('click', el.eventOnClick);
        document.removeEventListener('touchend', el.eventOnClick);
        el.removeAttribute('data-dragging');
    },
})

Object.defineProperty(Vue.prototype, '$http', {
    get() {
        return window.axios;
    },
});

Object.defineProperty(Vue.prototype, '$moment', {
    get() {
        return moment;
    }
});

import routes from '@js/routes';
import '@js/components.js';

Vue.use(VueRouter);
Vue.use(PortalVue);

let router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if (to?.meta?.title) {
        document.title = to.meta.title;
    }
    next();
});

store.dispatch('load').then(() => {
    window.app = new Vue({
        el: '#app',
        router,
        store
    });
})

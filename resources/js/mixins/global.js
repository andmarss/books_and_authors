import { reduce, isPlainObject, isNull, isUndefined, isArray, isObject } from 'lodash';

export default {
    data() {
        return {};
    },
    methods: {
        route() {
            let routes = window.site.routes;
            let args = Array.from(arguments);
            let name = args.shift();

            if (routes[name] === undefined) {
                console.error('Route not found ', name);
            } else {
                return `${window.site.baseUrl}/${routes[name].split('/').map(s => s[0] === '{' ? args.shift() : s).join(
                    '/')}`;
            }
        },
        goBack() {
            this.$router.go(-1);
        },
        getUserData() {
            if (localStorage.getItem('token')) {
                this.$http.get(this.route('user'), {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                }).then(({data}) => {
                    console.log(data);
                    this.user = data.data;
                });
            } else {
                this.user = null;
            }
        },
        objectToFormData(obj, form, namespace) {
            var fd = form || new FormData();
            var formKey = void 0;
            var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol"
                ? function (obj) {
                    return typeof obj;
                }
                : function (obj) {
                    return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype
                        ? "symbol"
                        : typeof obj;
                };

            for (let property in obj) {
                if (obj.hasOwnProperty(property)) {
                    if (namespace) {
                        formKey = namespace + '[' + property + ']';
                    } else {
                        formKey = property;
                    }

                    if (obj[property] instanceof Date) {
                        fd.append(formKey, obj[property].toISOString());
                    } else if (typeof obj[property] === 'object'
                        && !(obj[property] instanceof File)
                        && !(obj[property] instanceof Blob)) {
                        this.objectToFormData(obj[property], fd, formKey);
                    } else {
                        // if it's a string or a File object
                        fd.append(formKey, obj[property]);
                    }
                }
            }

            return fd;
        },
        objectToQueryString(obj) {
            let query = reduce(obj, function (result, value, key) {
                if (!isNull(value) && !isUndefined(value)) {
                    if (isArray(value)) {
                        result += reduce(value, function (result1, value1) {
                            if (!isNull(value1) && !isUndefined(value1)) {
                                result1 += encodeURIComponent(key) + '=' + encodeURIComponent(value1) + '&';
                                return result1
                            } else {
                                return result1;
                            }
                        }, '')
                    } else if (!isArray(value) && isObject(value)) {
                        result += ''; //this.objectToQueryString(value) + '&';
                    } else {
                        result += encodeURIComponent(key) + '=' + encodeURIComponent(value) + '&';
                    }
                    return result;
                } else {
                    return result
                }
            }, '').slice(0, -1);

            return (query ? '?' + query : '');
        },
    },

    computed: {
        user() {
            return this.$store.getters.user;
        },

        books() {
            return this.$store.getters.books;
        },

        booksCount() {
            return this.$store.getters.booksCount;
        },

        authors() {
            return this.$store.getters.authors;
        },

        genres() {
            return this.$store.getters.genres;
        }
    }
}

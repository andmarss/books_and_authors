<template>
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto" src="logo/self-pub-logo.png" alt="Self Publishing">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Зарегистрироваться
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Придумайте свой псевдоним
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="text" v-model="registerData.pseudonym" placeholder="Псевдоним" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="pseudonymError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="pseudonymError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="pseudonymError" v-if="pseudonymError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Пароль
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="password" v-model="registerData.password" placeholder="Пароль" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="passwordError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="passwordError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="passwordError" v-if="passwordError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Пароль еще раз
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="password" v-model="registerData.password_confirmation" placeholder="Пароль еще раз" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="passwordConfirmationError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="passwordConfirmationError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="passwordConfirmationError" v-if="passwordConfirmationError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Фамилия
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="text" v-model="registerData.last_name" placeholder="Фамилия" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="lastNameError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="lastNameError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="lastNameError" v-if="lastNameError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Имя
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="text" v-model="registerData.first_name" placeholder="Имя" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="firstNameError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="firstNameError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="firstNameError" v-if="firstNameError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Отчество <small>Не обязательно</small>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input :disabled="loading" type="text" v-model="registerData.middle_name" placeholder="Отчество" required class="w-full inline-flex justify-center py-2 px-4 border rounded-md shadow-sm bg-white text-sm font-medium" :class="middleNameError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'">
                            <div v-if="middleNameError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-red-600" v-html="middleNameError" v-if="middleNameError"></p>
                    </div>

                    <p class="mt-1 text-sm text-red-600" v-html="defaultError" v-if="defaultError"></p>

                    <div>
                        <button @click.prevent="register" type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Зарегистрироваться
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GlobalMixin from '@js/mixins/global';

export default {
    name: "Register",
    mixins: [GlobalMixin],
    data() {
        return {
            registerData: {
                pseudonym: '',
                password: '',
                password_confirmation: '',
                first_name: '',
                last_name: '',
                middle_name: ''
            },
            errors: {
                pseudonym: '',
                password: '',
                password_confirmation: '',
                first_name: '',
                last_name: '',
                middle_name: '',
                default: ''
            },
            loading: false,
            backdoor: 0
        }
    },
    methods: {
        register() {
            this.loading = true;
            this.clearError();

            this.$http.post(this.route('register'), this.registerData).then(({data}) => {
                if (data.data?.token) {
                    localStorage.setItem('token', data.data.token);
                    window.location = '/';
                } else {
                    this.errors.default = 'Токен не был получен';
                }
            }).catch(error => {
                let errors = error.response.data?.errors || {};

                for (let key in errors) {
                    if (this.errors.hasOwnProperty(key) && errors[key]?.length) {
                        this.errors[key] = errors[key][0];
                    }
                }

                this.backdoor++;
            }).then(() => {
                this.loading = false;
                setTimeout(() => {
                    this.clearError();
                }, 5000);
            });
        },
        clearError(error = '') {
            if (error) {
                this.errors[error] = '';
            } else {
                this.errors = {
                    pseudonym: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: '',
                    middle_name: '',
                    default: ''
                };
            }
        }
    },
    computed: {
        pseudonymError() {
            this.backdoor;
            return this.errors.pseudonym;
        },
        passwordError() {
            this.backdoor;
            return this.errors.password;
        },
        passwordConfirmationError() {
            this.backdoor;
            return this.errors.password_confirmation;
        },
        firstNameError() {
            this.backdoor;
            return this.errors.first_name;
        },
        lastNameError() {
            this.backdoor;
            return this.errors.last_name;
        },
        middleNameError() {
            this.backdoor;
            return this.errors.middle_name;
        },
        defaultError() {
            this.backdoor;
            return this.errors.default;
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="logo/self-pub-logo.png" alt="Self Publishing">
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Войти</h2>
            </div>
            <div class="-space-y-px rounded-md shadow-sm mt-6">
                <div>
                    <label for="pseudonym" class="sr-only">Псевдоним</label>
                    <p class="mt-2 text-sm text-red-600" id="email-error" v-html="pseudonymError" v-if="pseudonymError"></p>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="pseudonym" v-model="pseudonym" name="email" type="email" autocomplete="email" required class="relative block w-full px-3 py-2 appearance-none rounded-none rounded-t-md border  sm:text-sm" :class="pseudonymError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'" placeholder="Псевдоним">
                        <div v-if="pseudonymError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/exclamation-circle -->
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="password" class="sr-only">Пароль</label>
                    <div class="relative rounded-md shadow-sm">
                        <input id="password" v-model="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border rounded-b-md focus:outline-none sm:text-sm" :class="passwordError ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500'" placeholder="Пароль">
                        <div v-if="passwordError" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/exclamation-circle -->
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-red-600" id="password-error" v-html="passwordError" v-if="passwordError"></p>
                </div>
            </div>

            <p class="mt-2 text-sm text-red-600" id="default-error" v-html="defaultError" v-if="defaultError"></p>

            <div>
                <button type="submit" @click.prevent="login" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <!-- Heroicon name: mini/lock-closed -->
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    Войти
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import GlobalMixin from '@js/mixins/global';

export default {
    name: "Login",
    mixins: [GlobalMixin],
    data() {
        return {
            pseudonym: '',
            password: '',
            pseudonymError: '',
            passwordError: '',
            defaultError: ''
        }
    },
    methods: {
        login() {
            this.pseudonymError = '';
            this.passwordError = '';
            this.defaultError = '';

            this.$http.post(this.route('login'), {
                pseudonym: this.pseudonym,
                password: this.password
            })
            .then(({data}) => {
                if (data.data?.token) {
                    localStorage.setItem('token', data.data.token);
                    this.$router.push({name: 'authors.index'});
                } else {
                    this.defaultError = 'Токен не был получен';
                }
            })
            .catch(error => {
                let errors = error.response.data?.errors || {};

                if (errors.pseudonym) {
                    this.pseudonymError = errors.pseudonym[0];
                } else if (errors.password) {
                    this.passwordError = errors.password[0];
                }

                setTimeout(() => {
                    this.pseudonymError = '';
                    this.passwordError = '';
                    this.defaultError = '';
                }, 5000);
            });
        }
    }

}
</script>

<style scoped>

</style>

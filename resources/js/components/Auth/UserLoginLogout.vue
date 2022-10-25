<template>
    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
        <div v-if="!user">
            <a :href="route('login.form')" class="cursor-pointer whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                Войти
            </a>

            <router-link exact tag="h3" :to="{name: 'register'}" class="cursor-pointer ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Зарегистрироваться
            </router-link>
        </div>
        <simple-dropdown v-if="user">
            <template v-slot:user>
                {{user.pseudonym}}
            </template>
            <template v-slot:dropdown>
                <button @click.prevent="logout" class="px-1 py-2 text-center w-full cursor-pointer whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                    Выйти
                </button>
            </template>
        </simple-dropdown>
    </div>
</template>

<script>
import GlobalMixin from '@js/mixins/global';
import SimpleDropdown from '@components/Dropdown/Simple.vue';

export default {
    name: "UserLoginLogout",
    mixins: [GlobalMixin],
    data() {
        return {}
    },
    methods: {
        logout() {
            let token = localStorage.getItem('token');

            if (token) {
                localStorage.removeItem('token');
            }

            this.$http.post(this.route('logout'), {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            }).then(() => {
                this.$store.dispatch('updateUser', null);
                this.$router.push({name: 'authors.index'});
            }).catch(error => {
                console.log(error);
            });
        }
    },
    components: {
        'simple-dropdown': SimpleDropdown
    }
}
</script>

<style scoped>

</style>

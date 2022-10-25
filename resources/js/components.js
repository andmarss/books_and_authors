import Vue from 'vue';
import LoginForm from './components/Auth/Login.vue';
import UserLoginLogout from './components/Auth/UserLoginLogout.vue';
import RegisterForm from './components/Auth/Register.vue';

Vue.component('login-form', LoginForm);
Vue.component('user-login-logout', UserLoginLogout);
Vue.component('register-form', RegisterForm);

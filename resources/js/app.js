/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import PortalVue from 'portal-vue';
import VeeValidate from 'vee-validate';
import VueMoment from 'vue-moment';
import VueCookie from 'vue-cookie';
import Echo from 'laravel-echo';

import router from './router';
import vuetify from '@/plugins/vuetify';
import store from '@/store/index';
import i18n from '@/i18n';

import '@/components/global';
import '@/assets/style/app.scss';

Vue.use(VeeValidate);
Vue.use(PortalVue);
Vue.use(VueMoment);
Vue.use(VueCookie);

Vue.filter('fix2', val => {
	return Number(val).toFixed(2);
});

(async () => {
	try {
		const { data } = await axios.get(`/me`);
		Vue.prototype.$user = data;
	} catch (err) {}

	window.app = new Vue({
		store,
		router,
		vuetify,
		i18n,
		render: h => h('router-view')
	}).$mount('#app');
})();

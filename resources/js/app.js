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

import router from './router';
import vuetify from '@/plugins/vuetify';
import store from '@/store/index';

import '@/components/global';
import '@/assets/style/app.scss';

Vue.use(VeeValidate);
Vue.use(PortalVue);
Vue.use(VueMoment);
Vue.use(VueCookie);

Vue.use({
	async install(Vue, options) {
		const { data } = await axios.get('/me');
		Vue.prototype.$user = data;
	}
});

window.app = new Vue({
	store,
	router,
	vuetify,
	render: h => h('router-view')
}).$mount('#app');

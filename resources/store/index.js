import Vue from 'vue';
import Vuex from 'vuex';
import VueCookie from 'vue-cookie';
import modules from './modules'

Vue.use(Vuex);

export default new Vuex.Store({
	modules: modules,
	state: {
		page: {},
		dark: false,
		token: undefined,
		user: undefined
	},
	mutations: {
		dark(state, isDark) {
			state.dark = isDark;
		},
		setPage(state, page) {
			state.page = page;
		},
		setScrolling(state, scrolling) {
			state.page.scrolling = scrolling;
		},
		setUser(state, user) {
			state.user = user;
		}
	},
	actions: {
		async login(_, payload) {
			const { data } = await axios.post('/login', payload);
			if (data.api_token) {
				VueCookie.set('api_token', data.api_token, { expires: '2h' });
			}
		}
	}
});

import Vue from 'vue';
import Vuex from 'vuex';
import users from './modules/users';
import vouchers from './modules/vouchers';
import voucherGroups from './modules/voucher-groups';
import plans from './modules/plans';
import vips from './modules/vips';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		users,
		vouchers,
		voucherGroups,
		plans,
		vips
	},
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
			try {
				const { data } = await axios.post('/login', payload);
				if (data.api_token) {
					app.$cookie.set('api_token', data.api_token, { expires: '1m' });
				}
			} catch (e) {}
		}
	}
});

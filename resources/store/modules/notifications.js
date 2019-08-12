import { requestIndex } from '@/js/util';

export default {
	namespaced: true,
	state: {
		lists: [],
		unreadCount: 0,
		total: 0,
		page: 1
	},
	mutations: {
		set(state, lists) {
			state.lists = lists;
		},
		total(state, total) {
			state.total = total;
		},
		unreadCount(state, count) {
			state.unreadCount = count;
		}
	},
	actions: {
		async fetch({ commit, state }) {
			const [{ data: notifications }, { data: unreadNotificationCount }] = await Promise.all([
				axios.get('/notifications', {
					params: {
						page: state.page
					}
				}),
				axios.get('/notifications/unread')
			]);
			commit('set', notifications.data);
			commit('total', notifications.total);
			commit('unreadCount', unreadNotificationCount);
		},
		async markRead({ dispatch }, id) {
			const { data } = await axios.post(`notifications/${id}/read`);
			dispatch('read', data);
		},
		read({ state }, notification) {
			const index = state.lists.findIndex(e => e.id == notification.id);
			if (index >= 0) {
				state.lists.splice(index, 1, notification);
				--state.unreadCount;
			}
		},
		push({ state }, notification) {
			state.lists.splice(0, 0, notification);
			++state.unreadCount;
		}
	}
};

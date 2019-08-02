import { requestIndex } from '@/js/util';

export default {
	namespaced: true,
	state: {
		lists: [],
		options: {},
		totalGroups: 0
	},
	getters: {
		find(_) {
			return async id => {
				return (await axios.get(`/voucher-groups/${id}`)).data;
			};
		}
	},
	mutations: {
		set(state, lists) {
			state.lists.splice(0, state.lists.length, ...lists);
		},
		total(state, total) {
			state.totalGroups = total;
		}
	},
	actions: {
		async fetch(ctx, options) {
			requestIndex('/voucher-groups', ctx, options);
		},
		async archive({ dispatch }, groups) {
			await axios.post(`/voucher-groups/archive`, {
				groups: groups.map(e => e.id)
			});
			dispatch('fetch');
		}
	}
};

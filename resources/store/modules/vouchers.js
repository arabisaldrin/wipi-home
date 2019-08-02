import { requestIndex } from '@/js/util';
export default {
	namespaced: true,
	state: {
		lists: [],
		pagination: {},
		totalVouchers: 0,
		loading: false
	},
	getters: {
		find(_) {
			return async id => {
				return (await axios.get(`/vouchers/${id}`)).data;
			};
		}
	},
	mutations: {
		set(state, lists) {
			state.lists.splice(0, state.lists.length, ...lists);
		},
		total(state, total) {
			state.totalVouchers = total;
		}
	},
	actions: {
		async fetch(ctx, options) {
			requestIndex('/vouchers', ctx, options);
		},
		async add({ dispatch }, formData) {
			await axios.post('/vouchers', formData);
			await dispatch('fetch');
		},
		async remove({ dispatch }, id) {
			await axios.delete(`/vouchers/${id}`);
			await dispatch('fetch');
		},
		async update({ dispatch }, formData) {
			await axios.put(`/vouchers/${formData.id}`, formData);
			await dispatch('fetch');
		}
	}
};

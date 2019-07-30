import { requestIndex } from '@/js/util';

export default {
	namespaced: true,
	state: {
		lists: [],
		totalUser: 0
	},
	mutations: {
		set(state, lists) {
			state.lists.splice(0, state.lists.length, ...lists);
		},
		total(state, total) {
			state.totalUser = total;
		}
	},
	actions: {
		async fetch(ctx, options) {
			requestIndex('/users', ctx, options);
		},
		async add({ dispatch }, formData) {
			await axios.post('/users', formData);
			dispatch('fetch');
		},
		async remove({ dispatch }, id) {
			await axios.delete(`/users/${id}`);
			await dispatch('fetch');
		},
		async toggleStatus({ dispatch }, id) {
			await axios.put(`/users/${id}/toggle-status`);
			dispatch('fetch');
		},
		async update({ dispatch }, formData) {
			await axios.put(`/users/${formData.id}`, formData);
			dispatch('fetch');
		}
	}
};

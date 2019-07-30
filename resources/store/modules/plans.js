import { requestIndex } from '@/js/util';

export default {
	namespaced: true,
	state: {
		lists: [],
		totalPlans: 0
	},
	mutations: {
		set(state, lists) {
			state.lists.splice(0, state.lists.length, ...lists);
		},
		total(state, total) {
			state.totalPlans = total;
		}
	},
	actions: {
		async fetch(ctx, options) {
			requestIndex('/plans', ctx, options);
		},
		async add({ dispatch }, formData) {
			await axios.post('/plans', formData);
			await dispatch('fetch');
		},
		async remove({ dispatch }, id) {
			await axios.delete(`/plans/${id}`);
			await dispatch('fetch');
		},
		async update({ dispatch }, formData) {
			await axios.put(`/plans/${formData.id}`, formData);
			await dispatch('fetch');
		}
	}
};

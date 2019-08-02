import { requestIndex } from '@/js/util';

export default {
	namespaced: true,
	state: {
		lists: [],
		totalVip: 0
	},
	getters: {
		find(_) {
			return async id => {
				return (await axios.get(`/vips/${id}`)).data;
			};
		}
	},
	mutations: {
		set(state, lists) {
			state.lists.splice(0, state.lists.length, ...lists);
		},
		total(state, total) {
			state.totalVip = total;
		}
	},
	actions: {
		async fetch(ctx, options) {
			requestIndex('/vips', ctx, options);
		},
		async add({ dispatch }, formData) {
			await axios.post('/vips', formData);
			dispatch('fetch');
		},
		async remove({ dispatch }, id) {
			await axios.delete(`/vips/${id}`);
			await dispatch('fetch');
		},
		async toggleStatus({ dispatch }, id) {
			await axios.put(`/vips/${id}/toggle-status`);
			dispatch('fetch');
		},
		async update({ dispatch }, formData) {
			await axios.put(`/vips/${formData.id}`, formData);
			dispatch('fetch');
		}
	}
};

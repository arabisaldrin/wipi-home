import { requestIndex } from '@/js/util';

export default (api, override = {}) => {
	const store = {
		namespaced: true,
		state: {
			lists: [],
			totalItems: 0,
			options: {
				itemsPerPage: 10
			}
		},
		getters: {
			find(_) {
				return async id => {
					return (await axios.get(`/${api}/${id}`)).data;
				};
			}
		},
		mutations: {
			set(state, lists) {
				state.lists.splice(0, state.lists.length, ...lists);
			},
			total(state, total) {
				state.totalItems = total;
			}
		},
		actions: {
			async fetch(ctx, payload) {
				let options = payload;
				let transform;
				if ((payload || {}).options) {
					options = payload.options;
					transform = payload.transform;
				}
				requestIndex(`/${api}`, ctx, options, transform);
			},
			async add({ state }, formData) {
				const { data } = await axios.post(`/${api}`, formData);
				state.lists.push(data);
			},
			async remove({ state }, id) {
				await axios.delete(`/${api}/${id}`);

				const removeIndex = state.lists.findIndex(e => e.id == id);

				state.lists.splice(removeIndex, 1);
			},
			async update({ state }, formData) {
				const { data } = await axios.put(`/${api}/${formData.id}`, formData);

				const updateIndex = state.lists.findIndex(e => e.id == formData.id);

				state.lists.splice(updateIndex, 1, data);
			}
		}
	};

	Object.keys(store).forEach(e => {
		if (e === 'namespaced') return;
		Object.assign(store[e], override[e] || {});
	});

	return store;
};

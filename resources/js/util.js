import clone from 'lodash.clone';

export const requestIndex = async (api, { state, commit }, _options, transform = e => e) => {
	state.loading = true;
	let options = clone(_options || state.options);
	if (options) {
		options.sortDesc = (options.sortDesc || []).map(e => (e ? 'desc' : 'asc'));
		state.options = options;
	}
	const { data } = await axios.get(api, {
		params: options
	});

	const items = data.data ? transform(data.data) : transform(data);

	commit('set', items);
	commit('total', data.total || items.length);
	state.loading = false;
};

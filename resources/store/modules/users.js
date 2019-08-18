import _crud from '../_crud';

export default _crud('users', {
	actions: {
		async toggleStatus({ dispatch }, id) {
			await axios.put(`/users/${id}/toggle-status`);
			dispatch('fetch');
		}
	}
});

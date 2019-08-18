import _crud from '../_crud';

export default _crud('voucher-groups', {
	actions: {
		async archive({ state }, { group_id, archive = true }) {
			const { data } = await axios.post(`/voucher-groups/${group_id}/archive`, {
				archive
			});
			const updateIndex = state.lists.findIndex(e => e.id == group_id);
			state.lists.splice(updateIndex, 1, data);
		}
	}
});

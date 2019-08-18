import { mapActions, mapState } from 'vuex';
import clone from 'lodash.clone';
export default store => {
	return {
		data() {
			return {
				loading: false,
				options: {
					page: 1,
					itemsPerPage: 10
				}
			};
		},
		computed: {
			...mapState({
				items: state => state[store].lists,
				totalItems: state => state[store].totalItems
			})
		},
		methods: {
			...mapActions({
				fetch: `${store}/fetch`,
				remove: `${store}/remove`
			}),
			async reload() {
				this.loading = true;
				const opts = Object.assign(clone(this.options), this.extraOptions);
				await this.fetch(opts);
				this.loading = false;
			}
		},
		watch: {
			options: {
				deep: true,
				handler: 'reload'
			}
		}
	};
};

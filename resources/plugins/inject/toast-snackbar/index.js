import SnackBar from './Snackbar';
import vuetify from '@/plugins/vuetify';
const Install = {
	install(Vue, options) {
		const property = (options && options.property) || '$toast';
		var cmp;
		function createSnackBar() {
			cmp = new Vue(
				Object.assign(
					{
						vuetify
					},
					SnackBar,
					{
						propsData: Object.assign({}, Vue.prototype.$toast.options),
						destroyed: c => {
							document.body.removeChild(cmp.$el);
							cmp = null;
						}
					}
				)
			);

			document.body.appendChild(cmp.$mount().$el);
		}

		function show(message, color, options = {}) {
			options.message = message;
			options.color = color;
			if (!cmp) {
				createSnackBar();
			}
			cmp.queue(options);
		}

		Vue.prototype[property] = show;
		Vue.prototype[property].options = options || {};

		// Helper
		['success', 'error', 'warning', 'info'].forEach(e => {
			Vue.prototype[property][e] = (msg, option = {}) => {
				show(msg, e, option);
			};
		});
	}
};

export default Install;

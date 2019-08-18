import Confirm from './Confirm.vue';
import vuetify from '@/plugins/vuetify';

const Install = {
	install(Vue, options) {
		const property = (options && options.property) || '$confirm';
		function createDialogCmp(options) {
			return new Promise(resolve => {
				const cmp = new Vue(
					Object.assign(
						{
							vuetify
						},
						Confirm,
						{
							propsData: Object.assign({}, Vue.prototype.$confirm.options, options),
							destroyed: c => {
								document.body.removeChild(cmp.$el);
								resolve(cmp.value);
							}
						}
					)
				);
				document.body.appendChild(cmp.$mount().$el);
			});
		}

		function show(message, options = {}) {
			options.message = message;
			return createDialogCmp(options);
		}

		show.prototype.success = Vue.prototype[property] = show;
		Vue.prototype[property].options = options || {};
	}
};

export default Install;

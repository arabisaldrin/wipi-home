import VueI18n from 'vue-i18n';
import Vue from 'vue';

Vue.use(VueI18n);

const i18n = new VueI18n({
	locale: 'en-US',
	messages: {
		'en-US': {}
	}
});

export default i18n;

import VueI18n from 'vue-i18n';
import Vue from 'vue';

Vue.use(VueI18n);

const messages = {};

const requireComponent = require.context(
	// The relative path of the components folder
	'./lang',
	// Whether or not to look in subfolders
	false,
	// The regular expression used to match base component filenames
	/\w+\.(js)$/
);

requireComponent.keys().forEach(fileName => {
	// Get component config
	const langConfig = requireComponent(fileName);

	const lang = fileName
		.split('/')
		.pop()
		.replace(/\.\w+$/, '');

	messages[lang] = langConfig.default || langConfig;
});

const i18n = new VueI18n({
	locale: 'en-US',
	messages
});

export default i18n;

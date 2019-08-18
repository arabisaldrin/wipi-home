import Vue from 'vue';

const requireComponent = require.context(
	// The relative path of the components folder
	'.',
	// Whether or not to look in subfolders
	true,
	// The regular expression used to match base component filenames
	/\w+\.(js)$/
);

requireComponent.keys().forEach(fileName => {
	if (fileName === './index.js') return;

	// Get component config
	const componentConfig = requireComponent(fileName);

	Vue.use(componentConfig.default || componentConfig);
});

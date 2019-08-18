import lowerFirst from 'lodash.lowerfirst';
import camelCase from 'lodash.camelcase';

const modules = {};

const requireComponent = require.context(
	// The relative path of the components folder
	'.',
	// Whether or not to look in subfolders
	true,
	// The regular expression used to match base plugin filenames
	/\w+\.(js)$/
);

requireComponent.keys().forEach(fileName => {
	// Get plugin config
	const pluginConfig = requireComponent(fileName);

	// Get PascalCase name of plugin
	const pluginName = lowerFirst(
		camelCase(
			// Gets the file name regardless of folder depth
			fileName
				.split('/')
				.pop()
				.replace(/\.\w+$/, '')
		)
	);

	if (pluginName === 'index') return;

	modules[pluginName] = pluginConfig.default || pluginConfig;
});

export default modules;

export default {
	data() {
		return {
			dailyTime: null,
			sessionTime: null,
			speed: null,
			cap: null,
			map: [
				/**
				 * Coova-Chilli attribute mapping for auto conversion
				 */
				{
					type: 'check',
					prop: 'cap',
					attr: 'CoovaChilli-Max-Total-Octets',
					conversion: 1000000
				},
				{
					type: 'reply',
					prop: 'speed',
					attr: 'WISPr-Bandwidth-Max-Down',
					conversion: 8000000
				},
				{
					type: 'check',
					prop: 'dailyTime',
					attr: 'Max-Daily-Session',
					conversion: 60
				},
				{
					type: 'reply',
					prop: 'sessionTime',
					attr: 'Session-Timeout',
					conversion: 60
				}
			]
		};
	},
	methods: {
		convertFrom(data) {
			if (Array.isArray(data.check)) {
				data.check = {};
			}
			if (Array.isArray(data.reply)) {
				data.reply = {};
			}

			this.map.forEach(e => {
				if (data[e.type][e.attr]) {
					this[e.prop] = data[e.type][e.attr] / e.conversion;
				}
			});
		}
	},
	created() {
		this.map.forEach(e => {
			this.$watch(e.prop, val => {
				this.formData[e.type][e.attr] = val * e.conversion;
			});
		});
	}
};

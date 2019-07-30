export default {
	data() {
		return {
			dailyTime: null,
			sessionTime: null,
			speed: null,
			cap: null
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

			if (data.reply['CoovaChilli-Max-Total-Octets'])
				this.cap = data.reply['CoovaChilli-Max-Total-Octets'] / 1000000;
			if (data.reply['WISPr-Bandwidth-Max-Down']) this.speed = data.reply['WISPr-Bandwidth-Max-Down'] / 8000000;
			if (data.reply['Max-Daily-Session']) this.dailyTime = data.reply['Max-Daily-Session'] / 60;
			if (data.reply['Session-Timeout']) this.sessionTime = data.reply['Session-Timeout'] / 60;
		}
	},
	watch: {
		dailyTime(val) {
			// sec to min
			this.formData.reply['Max-Daily-Session'] = val * 60;
		},
		sessionTime(val) {
			// sec to min
			this.formData.reply['Session-Timeout'] = val * 60;
		},
		speed(val) {
			// bit -> mb
			this.formData.reply['WISPr-Bandwidth-Max-Down'] = val * 8000000;
		},
		cap(val) {
			// octet (byte) -> mb
			this.formData.reply['CoovaChilli-Max-Total-Octets'] = val * 1000000;
		}
	}
};

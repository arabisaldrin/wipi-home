export default [
	{
		text: 'Dashboard',
		icon: 'mdi-view-dashboard',
		route: '/'
	},
	{
		text: 'Users',
		icon: 'mdi-account-group',
		children: [
			{
				text: 'Subscriber',
				icon: 'mdi-credit-card',
				route: '/users'
			},
			{
				text: 'VIP',
				icon: 'mdi-account-badge-horizontal-outline',
				route: '/vip'
			}
		]
	},
	/* {
		text: 'Advertisements',
		icon: 'mdi-hospital-building',
		route: '/ads'
	}, */
	{
		text: 'Vouchers',
		icon: 'mdi-ticket-confirmation',
		route: '/vouchers'
	},
	{
		text: 'Plans',
		icon: 'mdi-cash-usd',
		route: '/plans'
	},
	{
		text: 'Test Voucher',
		icon: 'mdi-test-tube',
		route: '/voucher-test'
	}
	/* 	{
		text: 'Settings',
		icon: 'mdi-application',
		route: '/settings'
	} */
];

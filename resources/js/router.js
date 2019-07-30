import Vue from 'vue';
import routes from 'vue-auto-routing';
import VueRouter from 'vue-router';
import { createRouterLayout } from 'vue-router-layout';
import Page404 from '@/components/Page404';

Vue.use(VueRouter);

const RouterLayout = createRouterLayout(layout => {
	return import('@/layouts/' + layout + '.vue');
});

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			component: RouterLayout,
			children: routes
		},
		{
			path: '*',
			component: Page404
		}
	]
});

import Vue from 'vue';
import VueRouter from 'vue-router';

import Main from './../layouts/scaffold/Main.vue';
import Login from './../pages/Login.vue';
import NotFound from './../pages/Notfound.vue';

import Dashboard from '../pages/admin/Dashboard.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'nav-item active',
    routes: [
        {
            path: '',
            name: 'main',
            component: Main,
            meta: {
                requiresAuth: true
            },
            children: [
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                },
            
            ]

        },
        {
            path: "*",
            name: 'page-error-404',
            component: NotFound,
            meta: {
                requiresAuth: false
            },
        
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
       
    ]
});

router.beforeEach((to, from, next) => {

    const requiresAuth = to.matched.some((route) => route.meta.requiresAuth)

    const isAuthenticated = localStorage.getItem('token')

    if (!requiresAuth && isAuthenticated) {
        next(from);
    } else if (requiresAuth && !isAuthenticated) {
        next('/login');
    } else {
        next();
    }

	next();
});

export default router;
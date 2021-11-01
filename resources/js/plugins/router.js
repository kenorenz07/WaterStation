import Vue from 'vue';
import VueRouter from 'vue-router';

import Main from './../layouts/scaffold/Main.vue';
import Login from './../pages/Login.vue';
import NotFound from './../pages/Notfound.vue';

import Dashboard from '../pages/admin/index/Dashboard.vue';
import Customers from '../pages/admin/index/Customers.vue';
import DeliveryMen from '../pages/admin/index/DeliveryMen.vue';
import Products from '../pages/admin/index/Products.vue';
import Orders from '../pages/admin/index/Orders.vue';
import Sales from '../pages/admin/index/Sales.vue';
import Reviews from '../pages/admin/index/Review.vue';

import Customer from '../pages/admin/view/Customer.vue';
import DeliveryMan from '../pages/admin/view/DeliveryMan.vue';
import Product from '../pages/admin/view/Product.vue';
import Order from '../pages/admin/view/Order.vue';
import Sale from '../pages/admin/view/Sale.vue';

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

                // index
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                },
                {
                    path: '/products',
                    name: 'products',
                    component: Products,
                },
                {
                    path: '/customers',
                    name: 'customers',
                    component: Customers,
                },
                {
                    path: '/delivery-men',
                    name: 'delivery-men',
                    component: DeliveryMen,
                },
                {
                    path: '/orders',
                    name: 'orders',
                    component: Orders,
                },
                {
                    path: '/sales',
                    name: 'sales',
                    component: Sales,
                },
                {
                    path: '/reviews',
                    name: 'reviews',
                    component: Reviews,
                },

                // view
                {
                    path: '/product/:id',
                    name: 'product',
                    component: Product,
                },
                {
                    path: '/customer/:id',
                    name: 'customer',
                    component: Customer,
                },
                {
                    path: '/delivery-man/:id',
                    name: 'delivery-man',
                    component: DeliveryMan,
                },
                {
                    path: '/order/:id',
                    name: 'order',
                    component: Order,
                },
                {
                    path: '/sale/:id',
                    name: 'sale',
                    component: Sale,
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
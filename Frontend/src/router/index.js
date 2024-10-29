
import { createRouter, createWebHistory } from 'vue-router/auto'
import Cookies from 'js-cookie';

import Login from '@/pages/auth/Login.vue';
import Register from '@/pages/auth/Register.vue';
import Dashboard from '@/pages/dashboard/Dashboard.vue';
import ForgotPassword from '@/pages/auth/Forgot-Password.vue';
import Layout from '@/layouts/full/Layout.vue';
import Category from '@/pages/Category.vue';
import Assets from '@/pages/Assets.vue';
import Events from '@/pages/Events.vue';


const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requiresAuth: false
    }
  },
  {
    path: '/register',
    name: 'registration',
    component: Register,
    meta: {
      requiresAuth: false
    }
  },
  {
    path: '/forgot-password',
    name: 'forgotPassword',
    component: ForgotPassword,
    meta: {
      requiresAuth: false
    }
  },
  {
    path: '/',
    redirect: "/dashboard",
    component: Layout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
      },
      {
        path: '/category',
        name: 'category',
        component: Category,
      },
      {
        path: '/assets',
        name: 'assets',
        component: Assets,
      },
      {
        path: '/events',
        name: 'events',
        component: Events,
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})


router.beforeEach((to, from, next) => {
  const isLoggedIn = !!Cookies.get('auth_token');

  if (to.meta.requiresAuth && !isLoggedIn) {
    next({ name: 'login' });
  } else if (!to.meta.requiresAuth && isLoggedIn) {
    next({ name: 'dashboard' });
  } else {
    next();
  }
});


export default router

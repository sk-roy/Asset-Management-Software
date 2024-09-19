
import { createRouter, createWebHistory } from 'vue-router/auto'
import Cookies from 'js-cookie';

import Login from '@/pages/auth/Login.vue';
import Register from '@/pages/auth/Register.vue';
import Home from '@/pages/Home.vue';
import ForgotPassword from '@/pages/auth/Forgot-Password.vue';
import FullLayout from '@/layouts/full/FullLayout.vue';
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
    redirect: "/home",
    component: FullLayout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '/home',
        name: 'home',
        component: Home,
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
    next({ name: 'home' });
  } else {
    next();
  }
});


router.onError((err, to) => {
  if (err?.message?.includes?.('Failed to fetch dynamically imported module')) {
    if (!localStorage.getItem('vuetify:dynamic-reload')) {
      console.log('Reloading page to fix dynamic import error')
      localStorage.setItem('vuetify:dynamic-reload', 'true')
      location.assign(to.fullPath)
    } else {
      console.error('Dynamic import error, reloading page did not fix it', err)
    }
  } else {
    console.error(err)
  }
})

router.isReady().then(() => {
  localStorage.removeItem('vuetify:dynamic-reload')
})

export default router

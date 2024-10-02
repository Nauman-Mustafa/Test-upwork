import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/pages/Home.vue';
import Register from '../views/pages/Register.vue';
import Dashboard from '../views/pages/Dashboard.vue';

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/register',
    component: Register
  },
  {
    path: '/dashboard',
    component: Dashboard
  },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;

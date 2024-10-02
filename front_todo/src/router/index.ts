import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';  // Importar el store para acceder a los datos de autenticación
import LoginView from '@/views/LoginView.vue';
import RegisterView from '@/views/RegisterView.vue';
import NotFoundView from '@/views/NotFoundView.vue';
import HomeView from '@/views/HomeView.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/DashboardView.vue'),
    meta: { requiresAuth: true },  // Esta ruta requiere autenticación
  },
  {
    path:'/edit-note/:id',
    name:'edit-note',
    component: () => import('@/views/EditNoteView.vue'),
  },
  {
    path:'/create-note',
    name:'create-note',
    component: () => import('@/views/CreateNoteView.vue'),
  },
  {
    path:'/note/:id',
    name:'note',
    component: () => import('@/views/ShowNotesView.vue'),
  },
  {
    path:'/note',
    name:'note',
    component: () => import('@/views/ShowNotesView.vue'),
  },
  {
    path: '/:pathMatch(.*)*', // Ruta comodín para capturar cualquier ruta no definida
    name: 'NotFound',
    component: NotFoundView,  // Componente que muestra el mensaje de error 404
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

// Guard para validar rutas protegidas
router.beforeEach((to, from, next) => {
  const isAuthenticated = store.getters.isAuthenticated;

  // Verifica si la ruta tiene la meta requiresAuth
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      // Si no está autenticado, redirige al login
      next({ name: 'login' });
    } else {
      // Si está autenticado, permite el acceso
      next();
    }
  } else {
    // Si la ruta no requiere autenticación, permite el acceso
    next();
  }
});

export default router;
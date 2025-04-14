import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/user'

// Layouts
import AppLayout from '@/layouts/AppLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'

// Views
import DashboardView from '@/pages/DashboardView.vue'
import CursosView from '@/pages/admin/CursosView.vue'
import UsuariosView from '@/pages/admin/UsuariosView.vue'
import ConfiguracoesView from '@/pages/ConfiguracoesView.vue'
import LoginView from '@/pages/auth/LoginView.vue'
import RegisterView from '@/pages/auth/RegisterView.vue'
import MeusCursosView from '@/pages/MeusCursosView.vue'
import VitrineDeCursosView from '@/pages/VitrineDeCursosView.vue'

const routes = [
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: '', redirect: '/dashboard' },
      { path: 'cursos', component: CursosView },
      { path: 'usuarios', component: UsuariosView },
      { path: 'meuscursos', component: MeusCursosView },
      { path: 'vitrine' , component: VitrineDeCursosView},
      { path: 'dashboard', component: DashboardView },
      { path: 'configuracoes', component: ConfiguracoesView }
    ],
    meta: { requiresAuth: true }
  },
  {
    path: '/',
    component: AuthLayout,
    children: [
      { path: 'login', component: LoginView },
      { path: 'register', component: RegisterView }
    ]
  },
  // 404 fallback
  {
    path: '/:pathMatch(.*)*',
    redirect: '/login'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Proteção global
router.beforeEach((to, from, next) => {
  const userStore = useUserStore()

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!userStore.user) {
      return next('/login')
    }
  }

  next()
})

export default router

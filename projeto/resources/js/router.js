import { createRouter, createWebHistory } from 'vue-router'
import DashboardView from './pages/DashboardView.vue'
import CursosView from './pages/CursosView.vue'
import UsuariosView from './pages/UsuariosView.vue'
import ConfiguracoesView from './pages/ConfiguracoesView.vue'

const routes = [
  { path: '/dashboard', component: DashboardView },
  { path: '/cursos', component: CursosView },
  { path: '/usuarios', component: UsuariosView },
  { path: '/configuracoes', component: ConfiguracoesView },
  { path: '/', redirect: '/dashboard' },
]



const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
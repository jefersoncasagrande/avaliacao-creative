import { createRouter, createWebHistory } from 'vue-router'
import TarefasView from '../views/TarefasView.vue'
import TarefasTableView from '../views/TarefasTableView.vue'
import TarefasFormView from '../views/TarefasFormView.vue'
import UsuariosView from '../views/UsuariosView.vue'
import UsuariosTableView from '../views/UsuariosTableView.vue'
import UsuariosFormView from '../views/UsuariosFormView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      redirect: '/tarefas',
    },
    {
      path: '/tarefas',
      name: 'tarefas',
      component: TarefasView,
      children: [
        {
          path: '',
          name: 'tarefas-table',
          component: TarefasTableView
        },
        {
          path: 'novo',
          name: 'tarefas-novo',
          component: TarefasFormView
        },
        {
          path: ':id/editar',
          name: 'tarefas-editar',
          component: TarefasFormView
        }
      ]
    },
    {
      path: '/usuarios',
      name: 'usuarios',
      component: UsuariosView,
      children: [
        {
          path: '',
          name: 'usuarios-table',
          component: UsuariosTableView
        },
        {
          path: 'novo',
          name: 'usuarios-novo',
          component: UsuariosFormView
        },
        {
          path: ':id/editar',
          name: 'usuarios-editar',
          component: UsuariosFormView
        }
      ]
    },
  ]
})

export default router

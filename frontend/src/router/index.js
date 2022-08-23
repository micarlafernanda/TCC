import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/home',
    name: 'home',
    component: () => import(/* webpackChunkName: "home" */ '../views/home/Home.vue')
  },
  {
    path: '/medico',
    name: 'medico',
    component: () => import(/* webpackChunkName: "medico" */ '../views/medico/Medico.vue')
  },
  {
    path: '/busca',
    name: 'busca',
    component: () => import('../views/busca/Busca.vue')
  },
  {
    path: '/atendimento',
    name: 'atendimento',
    component: () => import(/* webpackChunkName: "atendimento" */ '../views/medico/Atendimento.vue')
  },
  {
    path: '/paciente',
    name: 'paciente',
    component: () => import(/* webpackChunkName: "paciente" */ '../views/paciente/Paciente.vue')
  },
  {
    path: '/familia',
    name: 'familia',
    component: () => import(/* webpackChunkName: "familia" */ '../views/familia/Familia.vue')
  },
  {
    path: '/consulta',
    name: 'consulta',
    component: () => import(/* webpackChunkName: "consulta" */ '../views/consulta/Consulta.vue')
  },
  {
    path: '/historico',
    name: 'historico',
    component: () => import(/* webpackChunkName: "historico" */ '../views/historico/Historico.vue')
  },
  {
    path: '/',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '../views/home/Login.vue')
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import(/* webpackChunkName: "admin" */ '../views/home/Cadastro.vue')
  },
  // {
  //   path: '/admin',
  //   name: 'admin',
  //   component: () => import(/* webpackChunkName: "admin" */ '../views/home/Admin.vue')
  // }
]

const router = new VueRouter({
  routes
})

export default router

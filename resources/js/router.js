import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import LandingPage from './components/pages/LandingPage'
import Tactic from './components/pages/Tactic'
import Technique from './components/pages/Technique'
import NotFound from './components/pages/404'

const routes = [
    {
        path: '/',
        name: 'home',
        component: LandingPage,
    },
    {
        path: '/tactic/:id',
        name: 'tactic',
        component: Tactic
    },
    {
        path: '/technique/:id',
        name: 'technique',
        component: Technique
    },
    {
        path: '/404',
        name: '404',
        component: NotFound
    },
    { 
        path: '/:pathMatch(.*)*', 
        component: NotFound,
    }
]

export default new Router({
    mode: 'history',
    routes,
    scrollBehavior() {
        return {x: 0, y: 0}
    }
})
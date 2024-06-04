import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        meta: {
            isLogged: [false],
            usedName: 'Home'
        },
        component: () => import('./Pages/Home.vue'),
    },
    {
        path: '/a/',
        name: 'Dashboard',
        meta: {
            isLogged: [true],
            usedName: 'Home'
        },
        component: () => import('./Pages/DashboardVue.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        component: () => import('./Pages/NotFound.vue'),
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
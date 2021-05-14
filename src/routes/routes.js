import layout from "@/views/layouts/Layout.vue"
import login from "@/views/system/Login.vue"

const routes = [{
        path: '/',
        redirect: 'home',
        component: layout,
        children: [{
                path: '/home',
                name: 'home',
                component: () =>
                    import ('../views/pages/Home.vue')
            },
            {
                path: '/clients',
                name: 'clients',
                component: () =>
                    import ('../views/pages/Clients.vue'),
            },
            {
                path: '/users',
                name: 'users',
                component: () =>
                    import ('../views/pages/Users.vue'),
            },
            {
                path: '/tickets',
                name: 'tickets',
                component: () =>
                    import ('../views/pages/Tickets.vue'),
            }
        ]
    },
    {
        path: '/',
        redirect: 'login',
        component: login,
        children: [{
            path: '/login',
            name: 'login',
            component: () =>
                import ('../views/system/Login.vue')
        }]
    }
]

export default routes;
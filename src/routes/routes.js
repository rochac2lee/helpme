import layout from "@/views/layouts/Layout.vue"
import layoutConfig from "@/views/layouts/LayoutConfig.vue"
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
                path: '/services',
                name: 'services',
                component: () =>
                    import ('../views/pages/Services.vue'),
            }
        ]
    },
    {
        path: '/config/site',
        component: layoutConfig,
        children: [{
                path: '/config/home',
                name: 'Home',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/pages',
                name: 'Pages',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/files',
                name: 'Files',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/emails',
                name: 'Emails',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/newsletter',
                name: 'Newsletter',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/themes',
                name: 'Themes',
                component: () =>
                    import ('../views/pages/Site.vue')
            },
            {
                path: '/config/advanced',
                name: 'Advanced',
                component: () =>
                    import ('../views/pages/Site.vue')
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
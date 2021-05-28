import Home from "../views/Home";

import Search from "../views/Search";

import Mybooks from "../views/Mybooks";

export default [{
        path: '/',
        component: Home,
        name: 'home',
        meta: {
            footer: true
        }
    },
    {
        path: '/search',
        component: Search,
        name: 'search'
    },
    {
        path: '/mybooks',
        name: 'mybooks',
        component: Mybooks
    },
    {
        path: '*',
        redirect: { name: 'home' }
    }
];
import Home from "../views/Home";

import Search from "../views/Search";

import Mybooks from "../views/Mybooks";

import Locale from '../locale/Locale'

let children = [{
        path: '',
        component: Home,
        meta: {
            name: '',
            footer: true
        }
    },
    {
        path: 'search',
        component: Search,
        meta: {
            name: 'search'
        }
    },
    {
        path: 'mybooks',
        component: Mybooks,
        meta: {
            name: 'mybooks'
        }
    },
    {
        path: 'full',
        name: 'full',
        component: () =>
            import ('../views/Full'),
        meta: {
            name: 'full'
        }
    },
]
export default [{
        path: '/',
        component: Locale,
        meta: {
            lang: null
        }
    },
    {
        path: '/en',
        component: Locale,
        meta: {
            lang: { lan: 'en', name: 'EN' },
        },
        children: children
    },
    {
        path: '/ru',
        component: Locale,
        meta: {
            lang: { lan: 'ru', name: 'RU' },
        },
        children: children
    },
    {
        path: '/kz',
        component: Locale,
        meta: {
            lang: { lan: 'kz', name: 'KZ' },
        },
        children: children
    }
];
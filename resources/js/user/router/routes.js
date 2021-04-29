import Home from "../views/Home";

import Search from "../views/Search";
import Full from "../views/Search/results/full_description";

import Mybooks from "../views/Mybooks";

export default [
{
    path: '/',
    component: Home,
    name: 'home',
    meta:{
        footer:true
    }
},
{
    path:'/search',
    component:Search,
    name:'search'
},
{
    path:'/full',
    component:Full
},
{
    path:'/mybooks',
    name:'mybooks',
    component:Mybooks
},
{
    path:'*',
    redirect:{name:'home'}
}
];

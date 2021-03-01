import Home from "../views/Home";
import Search from "../views/Search";
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
    path:'*',
    redirect:{name:'home'}
}
];

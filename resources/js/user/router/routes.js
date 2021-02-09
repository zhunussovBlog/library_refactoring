import Home from "../views/Home/Home";
import Search from "../views/Search/Search";
import FullDescription from "../views/Search/results/FullDescription";
import Profile from "../views/Profile/Profile";
export default [
    {
        path: '/',
        component: Home,
        name: 'home',
        meta:{
            backgrounded:false
        }
    },
    {
        path:'/search',
        component:Search,
        name:'search',
        meta:{
            backgrounded:false
        }
    },
    {
        path:'/full',
        component:FullDescription,
        name:'full',
        props:true
    },
    {
        path:'/profile',
        component:Profile,
        name:'profile'
    },
    {
    	path:'*',
    	beforeEnter:(to,from,next)=>{
    		next({name:'home'});
    	}
    }
];

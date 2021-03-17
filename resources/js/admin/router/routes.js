// acquisitions
import Batches from '../views/Acquisitions/Batches/Batches'
import Supplier from '../views/Acquisitions/Supplier/Supplier'
import Items from '../views/Acquisitions/Items/Items'
import Print from '../views/Acquisitions/Items/Print'
import Publisher from '../views/Acquisitions/Publisher/Publisher'

// service_desk
import Users from '../views/Service_desk/Users/Users'
import Info from '../views/Service_desk/Users/Info'
import Service from '../views/Service_desk/Users/Service'

// reports
// no lazy load -> to use lazy load just comment out these two routes in here and in routes
// lazy load future -- >  is good when u don't want to load a page in the beginning but only want to load when u need it
import Attendance from '../views/Reports/Attendance/Attendance'
import Books from '../views/Reports/BooksHistory/Books'
import MRBooks from '../views/Reports/MostReadBooks/Books'

// router
import Router from './Router'
export default
[
{
    path: '/',
    redirect:{name:'acquisitions'}
},
{
    path:'/acquisitions',
    name:'acquisitions',
    redirect:'acquisitions/batches',
    component:Router,
    children:[
    {
        path:'batches',
        name:'batches',
        component:Batches
    },
    {
        path:'items',
        name:'items',
        component:Items
    },
    {
        path:'suppliers',
        name:'suppliers',
        component:Supplier
    },
    {
        path:'publishers',
        name:'publishers',
        component:Publisher
    },
    {
        path:'print',
        component:Print,
    }
    ]
},
{
    path:'/reports',
    name:'reports',
    redirect:'reports/attendance',
    component:Router,
    children:[
    {
        path:'attendance',
        name:'attendance',
        component:Attendance
        // lazy load solution so that at the beginning the loading is faster ... but loading this ATTENDANCE component would take some time
        // component:()=>import ('../views/Reports/Attendance/Attendance')
    },
    {
        path:'most_read_books',
        name:'mrbooks',
        component:MRBooks
    },
    {
        path:'history_books',
        name:'books',
        component:Books
        // component:()=>import ('../views/Reports/Books/Books')
        // lazy load solution so that at the beginning the loading is faster ... but loading this BOOKS component would take some time
    }
    ]
},
{
    path:'/service',
    name:'service_desk',
    redirect:'service/users',
    meta:{
        // if there are no children then the default route would be the only route u can enter by navbar or sidebar
        noChildren:true
    },
    component:Router,
    children:[
    {
        path:'users',
        name:'users',
        component:Users
    },
    {
        path:'info',
        component:Info
    },
    {
        path:'service',
        props:true,
        component:Service
    }
    ]
},
{
    path:'*',
    redirect:'/'
}
];

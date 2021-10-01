const Welcome = () => import('./component/welcome')
const Classes = () => import('./component/classes/indexClass')
const ClassesAdd = () => import('./component/classes/createClass')

export const routes = [
    {
        name:'home',
        path:'/',
        component:Welcome
    },
    {
        name:'class',
        path:'/class',
        component:Classes
    },
    {
        name:'classAdd',
        path:'/class/add',
        component:ClassesAdd
    }
]
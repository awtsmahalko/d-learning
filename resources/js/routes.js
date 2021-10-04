const Welcome = () => import('./component/welcome')
const Classes = () => import('./component/classes/indexClass')
const ClassesAdd = () => import('./component/classes/createClass')
const ClassesEdit = () => import('./component/classes/editClass')

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
    },
    {
        name:'classEdit',
        path:'/class/edit/:id',
        component:ClassesEdit
    }
]
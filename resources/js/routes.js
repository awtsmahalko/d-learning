const Welcome = () => import('./component/welcome')
const Classes = () => import('./component/classes/indexClass')
const ClassesAdd = () => import('./component/classes/createClass')
const ClassesEdit = () => import('./component/classes/editClass')
const ClassesView = () => import('./component/classes/viewClass')

// for class list
const ClassList = () => import('./component/classlist/indexClassList');

const VideCon = () => import('./component/videocon/index')
const VideConJoin = () => import('./component/videocon/join')
const VideConMeeting = () => import('./component/videocon/meeting')

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
    },
    {
        name:'classView',
        path:'/class/view/:id',
        component:ClassesView
    },
    {
        name:'video',
        path:'/video',
        component:VideCon
    },
    {
        name:'videoJoin',
        path:'/video/join',
        component:VideConJoin
    },
    {
        name:'meeting',
        path:'/video/meeting',
        component:VideConMeeting
    },
    {
        name:"classlist",
        path:"/class-list",
        component:ClassList
    }
]
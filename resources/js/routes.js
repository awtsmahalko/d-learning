const Welcome = () => import('./component/welcome')
const Classes = () => import('./component/classes/indexClass')
const ClassesAdd = () => import('./component/classes/createClass')
const ClassesEdit = () => import('./component/classes/editClass')
const ClassesView = () => import('./component/classes/viewClass')

// for class list
const ClassList = () => import('./component/classlist/indexClassList');
const ClassListView = () => import('./component/classlist/viewClassList');

const VideCon = () => import('./component/videocon/index')
const VideConView = () => import('./component/videocon/view')
const VideConJoin = () => import('./component/videocon/join')
const VideConMeeting = () => import('./component/videocon/meeting')

const baseUrl = "";
export const routes = [
    {
        name:'home',
        path:baseUrl+'/',
        component:Welcome
    },
    {
        name:'class',
        path:baseUrl+'/class',
        component:Classes
    },
    {
        name:'classAdd',
        path:baseUrl+'/class/add',
        component:ClassesAdd
    },
    {
        name:'classEdit',
        path:baseUrl+'/class/edit/:id',
        component:ClassesEdit
    },
    {
        name:'classView',
        path:baseUrl+'/class/view/:id',
        component:ClassesView
    },
    {
        name:'video',
        path:baseUrl+'/video',
        component:VideCon
    },
    {
        name:'videoView',
        path:baseUrl+'/video/view/:id',
        component:VideConView
    },
    {
        name:'videoJoin',
        path:baseUrl+'/video/join',
        component:VideConJoin
    },
    {
        name:'meeting',
        path:baseUrl+'/video/meeting',
        component:VideConMeeting
    },
    {
        name:"classlist",
        path:baseUrl+"/class-list",
        component:ClassList
    },
    {
        name:"classlistView",
        path:baseUrl+"/class-list/view/:id",
        component:ClassListView
    }
]
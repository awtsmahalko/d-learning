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
const VideConMeeting = () => import('./component/videocon/meeting')
const ActivityViewTeacher = () => import('./component/classes/classtab/activityViewTeacher')
const ActivityViewStudent = () => import('./component/classes/classtab/activityViewStudent')

// profile
const ProfileView = () => import('./component/profile/indexProfile')

const baseUrl = "";
export const routes = [
    {
        name: 'home',
        path: baseUrl + '/',
        component: Welcome,
        meta: { title: 'Home' }
    },
    {
        name: 'class',
        path: baseUrl + '/class',
        component: Classes,
        meta: { title: 'Class' }
    },
    {
        name: 'classAdd',
        path: baseUrl + '/class/add',
        component: ClassesAdd,
        meta: { title: 'Add Class' }
    },
    {
        name: 'classEdit',
        path: baseUrl + '/class/edit/:id',
        component: ClassesEdit,
        meta: { title: 'Edit Class' }
    },
    {
        name: 'classView',
        path: baseUrl + '/class/:id',
        component: ClassesView,
        meta: { title: 'View Class' }
    },
    {
        name: 'video',
        path: baseUrl + '/video',
        component: VideCon,
        meta: { title: 'Video Conferencing' }
    },
    {
        name: 'videoView',
        path: baseUrl + '/video/view/:id',
        component: VideConView,
        meta: { title: 'View Meeting' }
    },
    {
        name: 'meeting',
        path: '/video/meeting/:id/:number/:password/:class_id/:api_key/:api_secret',
        component: VideConMeeting
    },
    {
        name: "classlist",
        path: baseUrl + "/class-list",
        component: ClassList,
        meta: { title: 'List of Students' }
    },
    {
        name: "classlistView",
        path: baseUrl + "/class-list/view/:id",
        component: ClassListView,
        meta: { title: 'Class List' }
    },
    {
        name: 'activityViewTeacher',
        path: baseUrl + '/class/:class_id/T/activity/:activity_id',
        component: ActivityViewTeacher,
        meta: { title: 'Activity' }
    },
    {
        name: 'activityViewStudent',
        path: baseUrl + '/class/:class_id/S/activity/:activity_id',
        component: ActivityViewStudent,
        meta: { title: 'Activity' }
    },
    {
        name: "profileView",
        path: baseUrl + "/profile",
        component: ProfileView
    }
]
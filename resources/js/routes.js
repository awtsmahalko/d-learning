const Welcome = () => import('./component/welcome')
const Classes = () => import('./component/classes/indexClass')
const ClassesView = () => import('./component/classes/viewClass')

// for class list
const ClassList = () => import('./component/classlist/indexClassList');
const ClassListView = () => import('./component/classlist/viewClassList');

const VideCon = () => import('./component/videocon/index')
const VideConView = () => import('./component/videocon/view')
const VideConMeeting = () => import('./component/videocon/meeting')
const ActivityViewTeacher = () => import('./component/classes/classtab/activityViewTeacher')
const ActivityViewStudent = () => import('./component/classes/classtab/activityViewStudent')

// students
const StudentIndex = () => import('./component/student/studentIndex')

// teacher
const TeacherIndex = () => import('./component/teacher/teacherIndex')

// profile
const ProfileView = () => import('./component/profile/indexProfile')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Welcome,
        meta: { title: 'Home' }
    },
    {
        name: 'class',
        path: '/class',
        component: Classes,
        meta: { title: 'Class' }
    },
    {
        name: 'classView',
        path: '/class/:id',
        component: ClassesView,
        meta: { title: 'View Class' }
    },
    {
        name: 'video',
        path: '/video',
        component: VideCon,
        meta: { title: 'Video Conferencing' }
    },
    {
        name: 'videoView',
        path: '/video/view/:id',
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
        path: "/class-list",
        component: ClassList,
        meta: { title: 'List of Students' }
    },
    {
        name: "classlistView",
        path: "/class-list/view/:id",
        component: ClassListView,
        meta: { title: 'Class List' }
    },
    {
        name: 'activityViewTeacher',
        path: '/class/:class_id/T/activity/:activity_id',
        component: ActivityViewTeacher,
        meta: { title: 'Activity' }
    },
    {
        name: 'activityViewStudent',
        path: '/class/:class_id/S/activity/:activity_id',
        component: ActivityViewStudent,
        meta: { title: 'Activity' }
    },
    {
        name: "profileView",
        path: "/profile",
        component: ProfileView
    },
    {
        name: "student",
        path: "/student",
        component : StudentIndex,
        meta: { title: 'Student' }
    },
    {
        name: "teacher",
        path: "/teacher",
        component : TeacherIndex,
        meta: { title: 'Teacher' }
    }
]
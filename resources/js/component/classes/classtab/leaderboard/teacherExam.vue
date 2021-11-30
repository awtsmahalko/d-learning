<template>
    <div class="card">
        <div class="card-body">
            <table border="1px" width="100%" style="text-align:center;
            ">
                <thead>
                    <tr>
                        <th>Student's Name</th>
                        <th v-for="(wQ , key) in workNumber" :key="key">{{ wQ.title + ' ' + wQ.points }}</th>
                        <th>Earned Points</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody v-if="studentWorks.length > 0">
                    <tr v-for="(workData,key) in studentWorks" :key="key">
                        <td>{{ workData.student_name }}</td>
                        <td v-for="(wQ , ky) in workNumber" :key="ky">{{ workData.work[ky] }}</td>
                        <td>{{ workData.earned_points }}</td>
                        <td>{{ workData.total_points }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name:'teacher-exam',
    data(){
        return {
            classId:'',
            studentWorks:[],
            workNumber:[]
        }
    },
    created(){
        this.classId = this.$route.params.id;
        this.fetchTeacherActivity();
    },
    methods:{
        fetchTeacherActivity(){
            axios
            .get(baseUrl + '/api/leaderboard/teacher/work',{
                params:{
                    class_id:this.classId,
                    category:'E'
                }
            }).then((res) => {
                this.studentWorks = res.data.student_list;
                this.workNumber = res.data.works;
            }).catch((error) =>{
                console.log(error);
            });
        }
    }
}
</script>
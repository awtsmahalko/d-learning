<template>
    <div class="card">
        <div class="card-body">
            <table border="1px" width="100%" style="text-align:center;
            ">
                <thead>
                    <tr>
                        <th>Students Name</th>
                        <th v-for="(wQ , key) in workNumber" :key="key">{{ wQ.title }}</th>
                        <th>Earned Points</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody v-if="studentWorks.length > 0">
                    <tr v-for="(workData,key) in studentWorks" :key="key">
                        <td>{{ workData.student_name }}</td>
                        <td v-for="(wQ , ky) in workNumber" :key="ky">{{ formatNumber(workData.work[ky]) }}</td>
                        <td>{{ formatNumber(workData.earned_points) }}</td>
                        <td>{{ formatNumber(workData.total_points) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name:'teacher-quiz',
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
                    category:'Q'
                }
            }).then((res) => {
                this.studentWorks = res.data.student_list;
                this.workNumber = res.data.works;
            }).catch((error) =>{
                console.log(error);
            });
        },
        formatNumber(value){
            value = parseFloat(value);
            return value.toFixed(2);
        }
    }
}
</script>
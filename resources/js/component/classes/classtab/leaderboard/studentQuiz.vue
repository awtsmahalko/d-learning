<template>
    <div class="card">
        <div class="card-body">
            <table border="1px" width="100%" style="text-align:center;
            ">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Student's ID</th>
                        <th>Earned Points</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody v-if="studentWorks.length > 0">
                    <tr v-for="(workData,key) in studentWorks" :key="key">
                        <td>{{ key+1 }}</td>
                        <td>{{ workData.user.student_id}}</td>
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
    name:'student-quiz',
    data(){
        return {
            classId:'',
            studentWorks:[]
        }
    },
    created(){
        this.classId = this.$route.params.id;
        this.fetchStudentQuiz();
    },
    methods:{
        fetchStudentQuiz(){
            axios
            .get(baseUrl + '/api/leaderboard/student/work',{
                params:{
                    class_id:this.classId,
                    category:'Q'
                }
            }).then((res) => {
                this.studentWorks = res.data;
                console.log(res.data);
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
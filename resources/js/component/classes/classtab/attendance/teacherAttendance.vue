<template>
    <div>
        <div class="col-md-12" v-show="is_teacher">
            <button
                type="button"
                class="btn btn-md btn-primary"
                @click="showAttendanceCreateModal"
            >
                <span class="material-icons"> add </span> Record
            </button>
        </div>
        <div class="card">
            <div class="card-body">
                <table border="1px" width="100%" style="text-align:center;
                ">
                    <thead>
                        <tr>
                            <th>Student's Name</th>
                            <th>Present</th>
                            <th>Late</th>
                            <th>Absent</th>
                        </tr>
                    </thead>
                    <tbody v-if="listAttendance.length > 0">
                        <tr v-for="(recordData , keyRecord) in listAttendance" :key="keyRecord">
                            <td>{{ recordData.lname+', '+recordData.fname}}</td>
                            <td>{{ recordData.attendance.filter(x => x.status == 'P').length }}</td>
                            <td>{{ recordData.attendance.filter(x => x.status == 'L').length }}</td>
                            <td>{{ recordData.attendance.filter(x => x.status == 'A').length }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <attendance-modal-create :classId="classId" :key="keyModal"/>
    </div>
</template>
<script>
import attendanceModalCreate from "./attendanceModalCreate.vue"

export default {
    components: { attendanceModalCreate },
    name:'teacher-attendance',
    data(){
        return {
            is_teacher:false,
            classId:'',
            keyModal:0,
            listAttendance:[]
        }
    },
    created(){
        this.is_teacher = sessionCategory == "T" ? true : false;
        this.classId = this.$route.params.id;
        this.fetchAttendaceRecord();
    }, 
    methods: {
        fetchAttendaceRecord(){
            axios.get(baseUrl + "/api/attendance/view/record", {
                params: {
                    class_id: this.classId
                },
            }).then((res) => {
                this.listAttendance = res.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        showAttendanceCreateModal(){
            $("#attendanceCreateModal").modal('show');
            this.resetFormAttendance();
        },
        resetFormAttendance(){
            this.keyModal++;
        }
    },
    mounted(){
        const thisInstance = this
        this.$root.$on('fetchAttendaceRecordEvent', function(){
            thisInstance.fetchAttendaceRecord()
        })
    }
}
</script>
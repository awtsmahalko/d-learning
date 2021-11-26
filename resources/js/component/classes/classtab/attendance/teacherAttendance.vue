<template>
    <div>
        <div class="col-md-12">
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
                    <tbody>
                        <tr>
                            <td>Gomed, Reynaldo</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Gomed, Reynaldo</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Gomed, Reynaldo</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Gomed, Reynaldo</td>
                            <td>50</td>
                            <td>50</td>
                            <td>50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <attendance-modal-create :classId="classId" v-on:resetFormAttendance="resetFormAttendance" />
    </div>
</template>
<script>
import attendanceModalCreate from "./attendanceModalCreate.vue"

export default {
    components: { attendanceModalCreate },
    name:'teacher-attendance',
    data(){
        return {
            classId:''
        }
    },
    created(){
        this.classId = this.$route.params.id;
    }, 
    methods: {
        showAttendanceCreateModal(){
            $("#attendanceCreateModal").modal('show');
            this.resetFormAttendance();
        },
        resetFormAttendance(){
            this.$emit("resetFormAttendance");
        }
    }
}
</script>
<template>
<div class="modal fade" id="attendanceCreateModal" tabindex="-1" role="dialog" aria-labelledby="attendanceCreateModalLabel" aria-hidden="true">
 	<div class="modal-dialog" role="document">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h5 class="modal-title" id="attendanceCreateModalLabel"> Record Attendance </h5>
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">×</span>
 				</button>
 			</div>
 			<!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
 			<form @submit.prevent="createAttendance">
 				<div class="modal-body">
                    <div class="form-group">
                        <input type="date" class="form-control" name="attendance_date" v-model="formAttendance.date" required>
                    </div>
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
 						<tbody v-if="modalStudents.length > 0">
 							<tr v-for="(studentData,key) in modalStudents" :key="key">
 								<td>{{ studentData.lname + ',' + studentData.fname + ' ' + studentData.mname }}</td>
 								<td><input @change="changeStatus(studentData.id,'P')" type="radio" :name="'status['+studentData.id+']'" value="P" required/></td>
 								<td><input @change="changeStatus(studentData.id,'L')" type="radio" :name="'status['+studentData.id+']'" value="L" required/></td>
 								<td><input @change="changeStatus(studentData.id,'A')" type="radio" :name="'status['+studentData.id+']'" value="A" required/></td>
 							</tr>
 						</tbody>
 					</table>
 				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"> Close </button>
                    <button type="submit" id="btn-submit" class="btn btn-sm btn-primary"> Save changes </button>
                </div>
 			</form>
 		</div>
 	</div>
</div>
</template>
<script>
export default {
    name:'attendance-modal-create',
    data(){
        return {
            formAttendance:{
                date:'',
                student:[],
                class_id:0
            },
            modalStudents: []
        }
    },
    created(){
        this.fetchAttendanceStudent();
        this.formAttendance.class_id = this.classId;
    },
    methods: {
        fetchAttendanceStudent(){
            axios.get(baseUrl + "/api/attendance/modal/students", {
                params: {
                    class_id: this.classId
                },
            }).then((data) => {
                this.modalStudents = data.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        createAttendance(){
            success_add();
            console.log(this.formAttendance);
            axios.post(baseUrl + "/api/attendance/add/record", this.formAttendance).then((data) => {
                console.log(data);
            }).catch((error) => {
                console.log(error);
            });

            $("#attendanceCreateModal").modal('hide');
        },
        generateName(id){
            return "status["+id+"]";
        },
        changeStatus(id,status){
            this.formAttendance.student[id] = status;
        },
        resetFormAttendance(){
            this.formAttendance = [];
            this.formAttendance.student = [];
        }
    },
    props : ["classId"],
}
</script>

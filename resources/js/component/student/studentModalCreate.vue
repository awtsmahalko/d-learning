<template>
    <div class="modal fade" id="studentCreateModal" tabindex="-1" role="dialog" aria-labelledby="studentCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentCreateModalLabel"> {{ modalLabel }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="ModalType == 'U' ? updateStudent() : createStudent()">
                    <div class="modal-body">
                        <div class="form-group bmd-form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <label>Student ID</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formStudent.student_id" required/>
                                </div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" style="width: 100%" v-model="formStudent.email"  required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group bmd-form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formStudent.fname"  required/>
                                </div>
                                <div class="col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formStudent.mname" />
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formStudent.lname"  required/>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ref="Close" class="btn btn-sm btn-secondary" data-dismiss="modal"> Close </button>
                        <button type="submit" id="btn-submit-student" class="btn btn-sm btn-primary"> Save changes </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'student-modal-create',
    props:["UserId","ModalType","StudentData"],
    data(){
        return {
            modalLabel:'',
            formStudent : {
                id:'',
                student_id : '',
                email : '',
                fname : '',
                mname : '',
                lname : ''
            },
        }
    },
    created(){
        this.modalLabel = this.ModalType == 'C' ? "Create New Student" : "Update Student Data";
        if(this.ModalType == 'U'){
            this.formStudent.student_id = this.StudentData.student_id;
            this.formStudent.email = this.StudentData.email;
            this.formStudent.fname = this.StudentData.fname;
            this.formStudent.mname = this.StudentData.mname;
            this.formStudent.lname = this.StudentData.lname;
            this.formStudent.id = this.StudentData.id;
        }
    },
    methods: {
        createStudent(){
            axios.post(baseUrl + "/api/student/add/record", this.formStudent ).then((res) => {
                if(res.data == 1){
                    success_add();
                }else if(res.data == 'id'){
                    entry_already_exists();
                }else if(res.data == 'email'){
                    entry_already_exists();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchStudentRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        },
        updateStudent(){
            axios.post(baseUrl + "/api/student/update/record", this.formStudent ).then((res) => {
                if(res.data == 1){
                    success_update();
                }else if(res.data == 'id'){
                    entry_already_exists();
                }else if(res.data == 'email'){
                    entry_already_exists();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchStudentRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        }
    }
}
</script>
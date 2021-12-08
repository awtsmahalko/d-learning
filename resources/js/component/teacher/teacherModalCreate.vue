<template>
    <div class="modal fade" id="teacherCreateModal" tabindex="-1" role="dialog" aria-labelledby="teacherCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherCreateModalLabel"> {{ modalLabel }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="ModalType == 'U' ? updateTeacher() : createTeacher()">
                    <div class="modal-body">
                        <div class="form-group bmd-form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <label>Teacher ID</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formTeacher.student_id" required/>
                                </div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" style="width: 100%" v-model="formTeacher.email"  required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group bmd-form-group">
                            <div class="col-md-12 row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formTeacher.fname"  required/>
                                </div>
                                <div class="col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formTeacher.mname" />
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" style="width: 100%" v-model="formTeacher.lname"  required/>
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
    name:'teacher-modal-create',
    props:["UserId","ModalType","TeacherData"],
    data(){
        return {
            modalLabel:'',
            formTeacher : {
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
        this.modalLabel = this.ModalType == 'C' ? "Create New Teacher" : "Update Teacher Data";
        if(this.ModalType == 'U'){
            this.formTeacher.student_id = this.TeacherData.student_id;
            this.formTeacher.email = this.TeacherData.email;
            this.formTeacher.fname = this.TeacherData.fname;
            this.formTeacher.mname = this.TeacherData.mname;
            this.formTeacher.lname = this.TeacherData.lname;
            this.formTeacher.id = this.TeacherData.id;
        }
    },
    methods: {
        createTeacher(){
            axios.post(baseUrl + "/api/teacher/add/record", this.formTeacher ).then((res) => {
                if(res.data == 1){
                    success_add();
                }else if(res.data == 'id'){
                    entry_already_exists();
                }else if(res.data == 'email'){
                    entry_already_exists();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchTeacherRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        },
        updateTeacher(){
            axios.post(baseUrl + "/api/teacher/update/record", this.formTeacher ).then((res) => {
                if(res.data == 1){
                    success_update();
                }else if(res.data == 'id'){
                    entry_already_exists();
                }else if(res.data == 'email'){
                    entry_already_exists();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchTeacherRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        }
    }
}
</script>
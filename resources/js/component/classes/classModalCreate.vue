<template>
    <div class="modal fade" id="classCreateModal" role="dialog" aria-labelledby="classCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classCreateModalLabel"> {{ modalLabel }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="ModalType == 'U' ? updateClass() : createClass()">
                    <div class="modal-body">
                        <div class="form-group bmd-form-group">
                            <label>Class Name</label>
                            <input type="text" class="form-control" style="width: 100%" v-model="formData.name" required />
                        </div>
                        <div class="form-group bmd-form-group">
                            <label>Class Description</label>
                            <input type="text" class="form-control" style="width: 100%" v-model="formData.description" required />
                        </div>
                        <div class="form-group bmd-form-group">
                            <label>Teacher</label>
                            <select class="form-control select2" style="width: 100%" id="user_id" required>
                                <option value="">-- Select Teacher --</option>
                                <option v-for="(values, keyTeacher) in teachers" :key="keyTeacher" :value="values.id" :selected="values.id == formData.user_id">
                                    {{ values.fname + " " + values.mname + " " + values.lname }}
                                </option>
                            </select>
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
    name:'class-modal-create',
    props:["UserId","ModalType","ModalData"],
    data(){
        return {
            modalLabel:'',
            formData : {
                id:'',
                name : '',
                code : '',
                description : '',
                user_id : ''
            },
            teachers : []
        }
    },
    created(){
        this.modalLabel = this.ModalType == 'C' ? "Create New Class" : "Update Class";
    
        if(this.ModalType == 'U'){
    
            this.formData.id = this.ModalData.id;
            this.formData.name = this.ModalData.name;
            this.formData.code = this.ModalData.code;
            this.formData.description = this.ModalData.description;
            this.formData.user_id = this.ModalData.user_id;
        }
    },
    mounted(){
        $(".select2").select2();
        this.fetchTeacherList();

        $("#user_id").change(
            function () {
                this.formData.user_id = $("#user_id").val();
            }.bind(this)
        );
    },
    methods: {
        createClass(){
            axios.post(baseUrl + "/api/class/add/record", this.formData ).then((res) => {
                $("#classCreateModal").modal('hide');
                if(res.data == 1){
                    success_add();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchClassRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        },
        updateClass(){
            axios.post(baseUrl + "/api/class/update/record", this.formData ).then((res) => {
                $("#classCreateModal").modal('hide');
                if(res.data == 1){
                    success_update();
                }else if(res.data == 'user'){
                    entry_already_exists();
                }else{
                    console.log(res.data);
                }
                this.$root.$emit('fetchClassRecordEvent');
            }).catch(error => {
                console.log(error);
            });
        },
        fetchTeacherList() {
            axios.get(baseUrl + "/api/class/user/category",{
                params:{
                    category:'T'
                }
            }).then((res) => {
                this.teachers = res.data;
            }).catch((error) => {
                console.log(error);
            });
        },
    }
}
</script>
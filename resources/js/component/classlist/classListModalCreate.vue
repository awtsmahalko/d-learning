<template>
    <!-- modal -->
    <div class="modal fade" id="addClassListModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form @submit.prevent="addStudent">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="exampleModalLabel"> Add Student to List </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group bmd-form-group">
                <label>Student</label>
                <select class="form-control select2" style="width: 100%" id="student_id" required>
                  <option value="">-- Select student --</option>
                  <option v-for="(values, key) in students" :key="key" :value="values.id">
                    {{ values.fname + " " + values.mname + " " + values.lname }}
                  </option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"> Save changes </button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- end modal -->
</template>
<script>
export default {
    name:'class-list-modal-create',
    props:["classesId"],
    data(){
        return {
            students : [],
            formData : {
                student_id : '',
                class_id : ''
            }
        }
    },
    created(){
        this.formData.class_id = this.classesId;
    },
    mounted(){
        $(".select2").select2();
        this.fetchStudents();

        $("#student_id").change(
            function () {
                this.formData.student_id = $("#student_id").val();
            }.bind(this)
        );
    },
    methods:{
        fetchStudents() {
            axios.get(baseUrl + "/api/studentsList/students", {
                params: {
                    user_id: sessionUserId,
                },
            })
            .then((data) => {
                this.students = data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        addStudent() {
            axios.post(baseUrl + "/api/studentsList", {
                student_list: this.formData,
            })
            .then((res) => {
                $("#addClassListModal").modal("hide");
                res.data == 1 ? success_add() : entry_already_exists();
                
                this.$root.$emit('fetchClassListRecordEvent');
            })
            .catch((error) => {
                console.log(error);
            });
        },
    }
}
</script>

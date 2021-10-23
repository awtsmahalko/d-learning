<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Class list</h4>
                <p class="card-category"> Here you can manage your list of students</p>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-12 text-right">
                        <button class="btn btn-sm btn-primary" v-on:click="showAddModal"> Add Student List </button>
                    </div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Student Name</th>
                                <th>Date Joined</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="studentsList.length > 0">
                            <tr v-for="(list,key) in studentsList" :key="key">
                                <td></td>
                                <td>{{ list.class.name }}</td>
                                <td>{{ list.user.fname + " "+list.user.mname+" "+list.user.lname}}</td>
                                <td></td>
                                <td><button class="btn btn-sm btn-danger"> REMOVE</button></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
              </div>
            </div>

            <!-- modal -->
            <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
                            <h5 class="modal-title" id="exampleModalLabel">Add Student to List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form @submit.prevent="addStudent">
                            <div class="modal-body">
                                <div class="form-group bmd-form-group">
                                    <label>Class</label>
                                    <select class="form-control select2" style="width:100%;" id="class_id" required>
                                        <option value="">-- Select class --</option>
                                        <option v-for="(values, key) in classes" :key="key" :value="values.id" > {{values.name}} </option>
                                    </select>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label>Student</label>
                                    <select class="form-control select2" style="width:100%;" id="student_id" required>
                                        <option value="">-- Select student --</option>
                                        <option v-for="(values, key) in students" :key="key" :value="values.id" > {{values.fname + " " +values.mname + " " +values.lname }} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal -->
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
export default {
    name:"classList",
    data(){
        return{
            classes:[],
            studentsList:[],
            students:[],
            studlist:{
                class_id:"",
                student_id:""
            }
        }
    },
    mounted(){
        $(".select2").select2();
        this.fetchStudentsList();
        this.fetchClasses();
        this.fetchStudents();

        $("#class_id").change(function(){
            this.studlist.class_id = $("#class_id").val();
        }.bind(this));

        $("#student_id").change(function(){
            this.studlist.student_id = $("#student_id").val();
        }.bind(this));
    },
    methods:{
        showAddModal(){
            this.resetForm();
            $("#addModal").modal('show');
        },
        fetchClasses(){
            axios.get("/api/class",{
                params:{
                    user_id:sessionUserId
                }
            }).then((data)=> {
                //alert(data);
                this.classes = data.data;
            }).catch( (error) => {
                alert(error);
            });
        },
        fetchStudents(){
            axios.get("/api/studentsList/students",{
                params:{
                    user_id:sessionUserId
                }
            }).then((data)=> {
                //alert(data);
                this.students = data.data;
            }).catch( (error) => {
                alert(error);
            });
        },
        fetchStudentsList(){
            axios.get("/api/studentsList",{
                params:{
                    user_id:sessionUserId
                }
            }).then((data)=> {
                //alert(data);
                console.log(data.data);
                this.studentsList = data.data;
            }).catch( (error) => {
                alert(error);
            });
        },
        addStudent(){
            axios.post("/api/studentsList",{
                student_list:this.studlist
            }).then((data)=> {
                // console.log(data);
                $("#addModal").modal('hide');
                success_add();
                this.fetchStudentsList();
            }).catch( (error) => {
                alert(error);
            });
        },
        resetForm(){
            $("#class_id").val('');
            $("#student_id").val('');

            $(".select2").select2().trigger('change');
        }
    }
}
</script>
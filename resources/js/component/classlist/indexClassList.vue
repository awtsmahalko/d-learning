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
                        <button class="btn btn-sm btn-primary" v-on:click="showAddModal"> Add Class </button>
                    </div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Creation date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    </div>
              </div>
            </div>

            <!-- modal -->
            <div class="modal" tabindex="-1" role="dialog" id="addModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label">Class</label>
                                <select class="form-control" v-model="studlist.class_id">
                                    <option>-- Select class --</option>
                                    <option v-for="(values, key) in classes" :key="key" :value="values.id" > {{values.name}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label">Student</label>
                                <select class="form-control" v-model="studlist.student_id">
                                    <option>-- Select student --</option>
                                    <option v-for="(values, key) in studentsList" :key="key" :value="values.id" > {{values.fname + " " +values.mname + " " +values.fname }} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" v-on:click="addStudent">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
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
            studlist:{
                class_id:"",
                student_id:""
            }
        }
    },
    mounted(){
        this.fetchClasses();
        this.fetchStudents();
    },
    methods:{
        showAddModal(){
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
            axios.get("/api/studentsList",{
                params:{
                    user_id:sessionUserId
                }
            }).then((data)=> {
                //alert(data);
                this.studentsList = data.data;
            }).catch( (error) => {
                alert(error);
            });
        },
        addStudent(){
            axios.post("/api/studentsList",{
                student_list:this.studlist
            }).then((data)=> {
                alert(data);
                console.log(data);
            }).catch( (error) => {
                alert(error);
            });
        }
    }
}
</script>
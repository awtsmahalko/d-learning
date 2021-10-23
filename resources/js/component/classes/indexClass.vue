<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Class</h4>
                <p class="card-category"> Here you can manage your classes</p>
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
                                <th>Code</th>
                                <th>Name</th>
                                <th>Creation date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="classes.length > 0">
                            <tr v-for="(clas,key) in classes" :key="key">
                                <td> {{ clas.code}} </td>
                                <td> {{ clas.name}} </td>
                                <td> {{ clas.created_at}} </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <router-link :to="{name: 'classView', params: { id: clas.id }}" class="btn btn-sm btn-primary">View</router-link>
                                        <router-link :to="{name: 'classEdit', params: { id: clas.id }}" class="btn btn-sm btn-success">Edit</router-link>
                                        <button class="btn btn-sm btn-danger" @click="deleteClass(clas.id)">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="4" align="center">No Classes Found</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    </div>    
    <!-- modal -->
    <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
                    <h5 class="modal-title" id="exampleModalLabel">Add New Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="addClass">
                    <div class="modal-body">
                        <div class="form-group bmd-form-group">
                            <label>Class Name</label>
                            <input type="text" class="form-control" style="width:100%;" v-model="form_class.name" required>
                        </div>
                        <div class="form-group bmd-form-group">
                            <label>Class Description</label>
                            <input type="text" class="form-control" style="width:100%;" v-model="form_class.description">
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
</template>
<script>
export default {
    name:"",
    data(){
        return {
            form_class:{
                user_id:sessionUserId,
                name:'',
                description:''
            },
            classes:[]
        }
    },
    mounted(){
        this.getClasses()
    },
    methods:{
        async getClasses(){
            await this.axios.get('/api/class',{
                params:{
                    user_id:sessionUserId
                }
            }).then(response => {
                this.classes = response.data
                console.log(response.data)
            }).catch(error=>{
                console.log(error)
                this.classes = []
            })
        },
        deleteClass(id){
            if(confirm("Are you sure to delete this class ?")){
                this.axios.delete(`/api/class/${id}`).then(response=>{
                    this.getClasses()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        showAddModal(){
            this.formReset();
            $("#addModal").modal('show');
        },
        addClass(){
            axios.post('/api/class',this.form_class).then(response=>{
                console.log(response);
                $("#addModal").modal('hide');
                this.getClasses(); 
                success_add();      
            }).catch(error=>{
                console.log(error)
            })
        },
        formReset(){
            this.form_class.name = "";
            this.form_class.description = "";
        }
    }
}
</script>
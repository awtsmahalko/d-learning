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
                        <router-link :to='{name:"classAdd"}' class="btn btn-sm btn-primary">
                            Add Class
                        </router-link>
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
  </div>
</template>
<script>
export default {
    name:"",
    data(){
        return {
            classes:[]
        }
    },
    mounted(){
        this.getClasses()
    },
    methods:{
        async getClasses(){
            await this.axios.get('/api/class',{
                user_id:sessionUserId
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
        }
    }
}
</script>
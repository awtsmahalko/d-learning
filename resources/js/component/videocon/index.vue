<template>
  <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Meetings</h4>
                        <p class="card-category"> Here you can manage your meetings</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-sm btn-primary" @click.prevent="showModal"> ADD MEETING</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>Class</th>
                                            <th>Title</th>
                                            <th>Time</th>
                                            <th>Creation date</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="meetings.length > 0">
                                        <tr v-for="(meeting,key) in meetings" :key="key">
                                            <td> {{ meeting.class}} </td>
                                            <td> {{ meeting.title}} </td>
                                            <td> {{ meeting.schedule}} </td>
                                            <td> {{ meeting.created_at}} </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <router-link :to="{name: 'classView', params: { id: meeting.id }}" class="btn btn-sm btn-primary">View</router-link>
                                                    <router-link :to="{name: 'classEdit', params: { id: meeting.id }}" class="btn btn-sm btn-success">Edit</router-link>
                                                    <button class="btn btn-sm btn-danger" @click="deleteClass(meeting.id)">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4" align="center">No Meeting Found</td>
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
          <!-- Modal containing dynamic form for adding/updating user details. -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
                <h5 v-show="isFormCreate" class="modal-title" id="exampleModalLabel">Add new meeting</h5>
                <h5 v-show="!isFormCreate" class="modal-title" id="exampleModalLabel">Update Meeting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
                <form @submit.prevent="isFormCreate ? createUser() : updateUser()">
                    <div class="modal-body">
                        <div class="form-group bmd-form-group">
                            <label>Class</label>
                            <select v-model="meeting.class_id" class="form-control" required>
                                <option value="">&mdash; Please Select &mdash; </option>
                                <option v-for="(clas,key) in classes" :value="clas.id" :key="key"> {{ clas.name }}</option>
                            </select>
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="bmd-label-floating">Title</label>
                            <input v-model="meeting.title" type="text" class="form-control" required>
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="bmd-label-floating">Description</label>
                            <input v-model="meeting.description" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary" v-show="isFormCreate">Save changes</button>
                        <button type="submit" class="btn btn-sm btn-primary" v-show="!isFormCreate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
  </div>
</template>

<script>

export default {
  
  name:"video",
    data(){
        return {
            meeting:{
                user_id:sessionUserId,
                class_id:'',
                title:'',
                description:''
            },
            meetings:[],
            classes:[],
            isFormCreate: true
        }
    },
    methods:{
        createMeeting(){
            axios.post('/api/video/create',this.meeting).then(response => {
                console.log(response.data)
            }).catch(error=>{
                console.log(error)
            })
        },
        showModal(){
            this.isFormCreate = true;

            this.meeting.class_id = '';

            $('#exampleModal').modal('show');
        },
        fetchClasses(){
            axios.get('/api/class',{
                params:{
                    user_id:sessionUserId
                }
            }).then(response => {
                this.classes = response.data;
                console.log(response.data)
            }).catch(error=>{
                console.log(error)
            })
        }
    },
    created(){
        this.fetchClasses();
    }
}
</script>
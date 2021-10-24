<template>
  <div class="content">
      <div class="container-fluid">
        <card-title :classesId="$route.params.id"></card-title>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Meetings</h4>
                        <p class="card-category"> Here you can manage your meetings</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right"  v-show="is_teacher">
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
                                            <td> {{ meeting.schedule_at}} </td>
                                            <td> {{ new Date(meeting.created_at).toLocaleString()}} </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <router-link to="#" class="btn btn-sm btn-primary"><span class="material-icons"></span> Join</router-link>
                                                    <router-link v-show="is_teacher" to="#" class="btn btn-sm btn-success">Edit</router-link>
                                                    <button v-show="is_teacher" class="btn btn-sm btn-danger" @click="deleteClass(meeting.id)">Delete</button>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
                <h5 class="modal-title" id="exampleModalLabel">Add new meeting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
                <form @submit.prevent="createMeeting">
                    <div class="modal-body">
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
                        <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
  </div>
</template>

<script>
import CardTitle from './../classes/cardTitle.vue';
export default {
  
  name:"video-view",
    data(){
        return {
            is_teacher:false,
            meeting:{
                user_id:sessionUserId,
                class_id:'',
                title:'',
                description:''
            },
            meetings:[]
        }
    },
    methods:{
        createMeeting(){
            axios.post('/api/video/create',this.meeting).then(response => {
                console.log(response.data);
                this.fetchMeeting();
                $('#exampleModal').modal('hide');
                success_add();
            }).catch(error=>{
                console.log(error)
            })
        },
        fetchMeeting(){
            axios.get('/api/video',{
                params:{
                    user_id:sessionUserId,
                    category:sessionCategory,
                    class_id:this.meeting.class_id
                }
            }).then(response => {
                this.meetings = response.data;
            }).catch(error=>{
                console.log(error)
            })
        },
        showModal(){
            $('#exampleModal').modal('show');
        }
    },
    created(){
        this.is_teacher = sessionCategory == 'T' ? true : false;
        this.meeting.class_id = this.$route.params.id;
        this.fetchMeeting();
    },
    components:{
        CardTitle
    }
}
</script>
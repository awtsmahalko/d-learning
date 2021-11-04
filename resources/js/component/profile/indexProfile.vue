<template>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 ml-auto mr-auto">
                    <div class="profile" style="text-align:center;">
                        <!--<div class="avatar">
                            <img src="" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                        </div>-->
                        <div class="name">
                            <h3 class="title" style="text-transform: uppercase;">{{ profileDetails.profile_name }}</h3>
                            <h6>{{ profileDetails.profile_category == 'T' ? 'Teacher' : 'Student' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="description text-center">
            <p>Manage your profile information here.</p>
            </div>
            <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="profile-tabs">
                    <ul class="nav nav-pills nav-pills-icons justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">
                                <i class="material-icons">person</i> My Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#classes" role="tab" data-toggle="tab">
                                <i class="material-icons">palette</i> My classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#security" role="tab" data-toggle="tab">
                                <i class="material-icons">lock</i> Security
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="tab-content tab-space">
                <div class="tab-pane active" id="profile">
                    <br/>
                    <div class="row">
                        <div class="col-sm-6 ml-auto mr-auto">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">First Name</label>
                                <input type="text" class="form-control" v-model="profileDetails.fname" required />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Middle Name</label>
                                <input type="text" class="form-control" v-model="profileDetails.mname" />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Last Name</label>
                                <input type="text" class="form-control" v-model="profileDetails.lname" required />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" v-model="profileDetails.email" required />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Username</label>
                                <input type="text" class="form-control" v-model="profileDetails.username" required />
                            </div>

                            <button class="btn btn-primary" id="btn_update_profile" @click="updateProfile()" >Save Changes</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane text-center" id="classes">
                    <br />
                    <div class="row">
                        <div class="col-md-6 ml-auto mr-auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="classes.length > 0">
                                        <tr v-for="(row, key) in classes" :key="key">
                                            <td>{{ row.code }}</td>
                                            <td>{{ row.name }}</td>
                                            <td>
                                                <router-link
                                                :to="{
                                                    name: 'classView',
                                                    params:{ id: row.id }
                                                }" class='btn btn-primary btn-sm'> View
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="2">No classes found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="security">
                    <br/>
                    <div class="row">
                        <div class="col-sm-6 ml-auto mr-auto">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Old Password</label>
                                <input type="password" class="form-control" v-model="profileDetails.old_password" required />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">New Password</label>
                                <input type="password" class="form-control" v-model="profileDetails.new_password" required />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Confirm New Password</label>
                                <input type="password" class="form-control" v-model="profileDetails.confirm_new_password" required />
                            </div>

                            <button class="btn btn-primary" id="btn_update_password" @click="updatePassword()" >Update Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name:"indexProfile",
    data(){
        return{
            profileDetails:{
                user_id:window.sessionUserId,
                profile_name:window.sessionFullname,
                profile_category:window.sessionCategory,
                fname:window.sessionFname,
                mname:window.sessionMname,
                lname:window.sessionLname,
                email:window.sessionEmail,
                username:window.sessionUsername,
                old_password:'',
                new_password:'',
                confirm_new_password:'',
            },
            classes:[]
        }
    },
    mounted(){
        this.getClasses()
    },
    methods:{
        getClasses() {
            axios.get(baseUrl + "/api/class", {
                params: {
                    user_id: this.profileDetails.user_id,
                    category: this.profileDetails.profile_category,
                },
            }).then((response) => {
                this.classes = response.data;
            }).catch((error) => {
                failed_query(error);
            });
        },
        updateProfile(){

            $("#btn_update_profile").prop('disabled', true);
            axios.post( baseUrl + "/api/updateProfile",{
                id:this.profileDetails.user_id,
                fname:this.profileDetails.fname,
                mname:this.profileDetails.mname,
                lname:this.profileDetails.lname,
                email:this.profileDetails.email,
                username:this.profileDetails.username
            }).then( (data) =>{
                success_update();
                $("#btn_update_profile").prop('disabled', false);
            } ).catch( (error) => {
                failed_query(error);
            });
        },
        updatePassword(){
            
            $("#btn_update_password").prop('disabled', true);
            axios.post(baseUrl + "/api/updatePassword",{
                id:this.profileDetails.user_id,
                old_password:this.profileDetails.old_password,
                new_password:this.profileDetails.new_password,
                confirm_new_password:this.profileDetails.confirm_new_password
            }).then( ({data}) => {
                if(data == 1){
                    success_update();
                }else{
                    failed_query(data);
                }

                $("#btn_update_password").prop('disabled', false);
            }).catch( (error) => {
                failed_query(error);
            });
        }
    }
}

</script>

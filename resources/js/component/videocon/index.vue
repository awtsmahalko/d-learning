<template>
  <div class="content">
      <div class="container-fluid">
          <div class="row">
          <div class="col-md-8">
              <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title">Vide Con</h4>
                  <p class="card-category">Create video con</p>
              </div>
              <div class="card-body">
                  <button type="button" @click="createMeeting" class="btn btn-primary pull-right"><span class="material-icons">add_circle_outline</span> Add Class</button>
                  <div class="clearfix"></div>
              </div>
              </div>
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
                user_id:sessionUserId
            }
        }
    },
    methods:{
        async createMeeting(){
            await this.axios.post('/api/video/create',this.meeting).then(response => {
                console.log(response.data)
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>
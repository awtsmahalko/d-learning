<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitPost">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label>Share to your class</label>
                                            <textarea v-model="post.description" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary"><span class="material-icons">edit</span> POST</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                    <div v-if="posts.length > 0">
                        <div v-for="(post,key) in posts" :key="key" class="card">
                            <div class="card-header">
                                <h4 class="card-title ">{{ post.user.fname}}</h4>
                                <p class="card-category"> {{ post.created_at }}</p>
                            </div>
                            <div class="card-body">
                                {{ post.description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Disscusion</li>
                                <li class="list-group-item">Activities</li>
                                <li class="list-group-item">People</li>
                                <li class="list-group-item">Files</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"view-class",
    data(){
        return {
            posts:[],
            post:{
                user_id:sessionUserId,
                class_id:'',
                description:''
            }
        }
    },
    created(){
      this.post.class_id = this.$route.params.id;
    },
    mounted(){
        this.getPosts()
    },
    methods:{
        async getPosts(){
            await this.axios.get('/api/post',{
                user_id:sessionUserId,
                class_id:this.$route.params.id
            }).then(response => {
                this.posts = response.data
                console.log(response.data)
            }).catch(error=>{
                console.log(error)
                this.posts = []
            })
        },
        submitPost() {
            this.axios.post('/api/post',this.post).then(response => {
                console.log(response.data)
                this.getPosts()
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>
<template>
  <div class="content">
    <div class="container-fluid">
        <div class="row" v-if="classes.length > 0">
            <div class="col-lg-4 col-md-6 col-sm-6" v-for="(clas, key) in classes" :key="key" @click="alert(clas.id)">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">videocam</i>
                        </div>
                        <p class="card-category">{{ clas.code }}</p>
                        <h3 class="card-title">{{ clas.name }}</h3>
                        <p class="card-category">{{ clas.description }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <i class="material-icons text-primary">videocam</i>
                        <router-link :to="{name: 'videoView', params: { id: clas.id }}">{{ is_teacher ? clas.class_lists.length : clas.meetings.length  }} meetings</router-link>
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
    name:"classList",
    data(){
        return{
            is_teacher : false,
            classes:[]
        }
    },
    created(){
        this.is_teacher = sessionCategory == 'T' ? true : false;
    },
    mounted(){
        this.fetchClasses();
    },
    methods:{
        fetchClasses(){
            axios.get("/api/class",{
                params:{
                    user_id:sessionUserId,
                    category:sessionCategory
                }
            }).then((data)=> {
                console.log(data.data);
                //alert(data);
                this.classes = data.data;
            }).catch( (error) => {
                alert(error);
            });
        },
    }
}
</script>
<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-background">
            <div
                class="full-background"
                style="
                background-image: url(@'public/material/img/class.jpg')"
            ></div>
            <div class="card-body pt-12">
                <h2 class="font-weight-bold pt-2">
                {{ classData.name }}
                </h2>
                <p>
                Class code: <b>{{ classData.code }}</b>
                </p>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'card-title',
    props:[
        'classesId'
    ],
    data(){
        return {
            classData:{
                name:'',
                code:''
            }
        }
    },
    created(){
        this.fetchTitleData();
    },
    methods:{
        fetchTitleData(){
            this.axios.get(`/api/class/${this.classesId}`).then((res) => {
            this.classData = res.data;
            });
        },
    }
}
</script>
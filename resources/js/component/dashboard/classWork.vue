<template>
    <div class="col-md-12">
    	<!-- start loop -->
    		<class-work-student v-if="category == 'S'" :activities="activities" />
    	    <class-work-teacher v-if="category == 'T'" :activities="activities" />
    	    <class-work-admin v-if="category == 'A'" :activities="activities" />
    	<!-- end loop -->
    </div>
</template>
<script>
import ClassWorkStudent from './classWorkStudent.vue';
import classWorkTeacher from './classWorkTeacher.vue';
import classWorkAdmin from './classWorkAdmin.vue';
var last_date = "",last_class = "";
export default {
  components: { classWorkTeacher, ClassWorkStudent ,classWorkAdmin},
    name:'dashboard-work',
    data() {
        return {
            activities: [],
            is_teacher:false,
            category : false
        }
    },
    mounted() {
        this.getActivity();
        this.is_teacher = sessionCategory == "T" ? true : false;
        this.category = sessionCategory;
    },

    methods:{
        getActivity() {
            axios.get(baseUrl + "/api/class/activity/dashboard", {
                params: {
                    user_id: sessionUserId,
                    class_id: 0,
                    view_by:sessionCategory
                },
            }).then((response) => {
                this.activities = response.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        isDateEqual(value){
            const d = new Date(value);
            const _date = d.getMonth() + "-" + d.getDate() + "-" + d.getFullYear();
            _date == last_date ? false:last_class = "";
            return _date == last_date ? false:true;
        },
        isClassEqual(value,assign = 1){
            
            const _last_class = last_class;
            assign == 1 ? last_class = value : '';
            return value == _last_class ? true:false;
        }
    }
}
</script>

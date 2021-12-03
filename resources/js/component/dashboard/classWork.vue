<template>
    <div class="col-md-12">
      <!-- start loop -->
      <div v-for="(activity, key) in activities" :key="key">
        <div class="row" v-show="isDateEqual(activity.duedate)">
            <h3>{{ formatDate(activity.duedate) }}</h3>
        </div>
          <div v-if="is_teacher">
            <class-work-teacher :activity="activity" />
          </div>
          <div v-else>
            <class-work-student :activity="activity" />
          </div>
      </div>
      <!-- end loop -->
    </div>
</template>
<script>
import ClassWorkStudent from './classWorkStudent.vue';
import classWorkTeacher from './classWorkTeacher.vue';
var last_date = "";
export default {
  components: { classWorkTeacher, ClassWorkStudent },
    name:'dashboard-work',
    data() {
        return {
            activities: [],
            is_teacher:false
        }
    },
    mounted() {
        this.getActivity();
        this.is_teacher = sessionCategory == "T" ? true : false;
    },

    methods:{
        getActivity() {
            axios.get(baseUrl + "/api/class/activity/view", {
                params: {
                    user_id: sessionUserId,
                    class_id: 0,
                },
            }).then((response) => {
                this.activities = response.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        formatDate(value){
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const d = new Date(value);
            last_date = d.getMonth() + "-" + d.getDate() + "-"+d.getFullYear();
            return months[d.getMonth()] + " " + d.getDate() + ", "+d.getFullYear();
            // return moment(String(value)).format('MM/DD/YYYY hh:mm')
        },
        isDateEqual(value){
            const d = new Date(value);
            const _date = d.getMonth() + "-" + d.getDate() + "-" + d.getFullYear();
            return _date == last_date ? false:true;
        }
    }
}
</script>

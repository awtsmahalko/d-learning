<template>
    <div class="col-md-12">
      <!-- start loop -->
      <div class="card my-2" v-for="(activity, key) in activities" :key="key">
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
    }
}
</script>

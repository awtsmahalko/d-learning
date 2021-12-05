<template>
    <div class="col-md-12">
      <!-- start loop -->
      <div v-for="(activity, keyDate) in activities" :key="keyDate">
        <div class="row">
            <h3>{{ keyDate }}</h3>
        </div>
        <div v-for="(rowData,key) in activity" :key="key">
            <div class="card">
                <table style="width:100%;padding:5px;border-radius:15px;" border="1">
                    <tr align="center">
                        <td width="20%" :rowspan="rowData.length + 1"><b>{{ rowData[0].class.name }}</b><br> {{ rowData[0].user.fname + ' ' + rowData[0].user.lname}}</td>
                    </tr>
                    <tr v-for="(actRow,keyRow) in rowData" :key="keyRow">
                        
                        <td style="padding:10px;border-right:none;">
                            <b>{{
                            actRow.category == "A"
                                ? "ACTIVITY"
                                : actRow.category == "E"
                                ? "EXAM"
                                : "QUIZ"
                            }}</b>
                            <router-link
                            :to="{
                                name: 'activityViewStudent',
                                params: {
                                class_id: actRow.class_id,
                                activity_id: actRow.id,
                                },
                            }"
                            >: <b>{{ actRow.title }} </b>
                    
            </router-link>
                    </td>
                        <td style="padding:10px;border-left:none;" align="right">DUE: {{ formatDate(actRow.duedate) }}</td>
                        
                    </tr>
                </table>
            </div>
        </div>     
    </div>
      <!-- end loop -->
    </div>
</template>
<script>
import ClassWorkStudent from './classWorkStudent.vue';
import classWorkTeacher from './classWorkTeacher.vue';
var last_date = "",last_class = "";
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
        formatDate(value){
            return moment(String(value)).format('hh:mm A')
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

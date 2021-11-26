<template>
    <div v-if="is_teacher">
        <teacher-attendance/>
    </div>
    <div v-else>
        <student-attendance />
    </div>
</template>
<script>
import studentAttendance from './studentAttendance.vue';
import teacherAttendance from './teacherAttendance.vue';
export default{
    name:'attendance-index',
    components : {studentAttendance,teacherAttendance},
    data(){
        return {
            is_teacher:false
        }
    },
    mounted(){
        this.is_teacher = sessionCategory == "T" ? true : false;
    }
}
</script>
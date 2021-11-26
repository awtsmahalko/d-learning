<template>
    <div>
      <ul class="nav nav-pills mb-3" id="pills-tab-leaderboard" role="tablist">
        <li class="nav-item" role="presentation">
          <a
            class="nav-link active"
            id="pills-quiz-tab"
            data-toggle="pill"
            href="#pills-quiz"
            role="tab"
            aria-controls="pills-quiz"
            aria-selected="true"
            >Quiz</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-exam-tab"
            data-toggle="pill"
            href="#pills-exam"
            role="tab"
            aria-controls="pills-exam"
            aria-selected="true"
            >Exam</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-activity-tab"
            data-toggle="pill"
            href="#pills-activity"
            role="tab"
            aria-controls="pills-activity"
            aria-selected="true"
            >Activity</a
          >
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent-leaderboard">
        <div
          class="tab-pane fade show active"
          id="pills-quiz"
          role="tabpanel"
          aria-labelledby="pills-quiz-tab"
        >
            <div v-if="is_teacher"><teacher-quiz /></div>
            <div v-else><student-quiz /></div>
        </div>
        <div
          class="tab-pane fade"
          id="pills-exam"
          role="tabpanel"
          aria-labelledby="pills-exam-tab"
        >
            <div v-if="is_teacher"><teacher-exam /></div>
            <div v-else><student-exam /></div>
        </div>
        <div
          class="tab-pane fade"
          id="pills-activity"
          role="tabpanel"
          aria-labelledby="pills-activity-tab"
        >
            <div v-if="is_teacher"><teacher-activity /></div>
            <div v-else><student-activity /></div>
        </div>
      </div>
    </div>
</template>
<script>
import TeacherQuiz from './teacherQuiz.vue';
import TeacherExam from './teacherExam.vue';
import TeacherActivity from './teacherActivity.vue';
import StudentQuiz from './studentQuiz.vue';
import StudentExam from './studentExam.vue';
import StudentActivity from './studentActivity.vue';
export default {
    name:'leaderboard-index',
    components:{TeacherQuiz , TeacherExam, TeacherActivity , StudentQuiz , StudentExam , StudentActivity},
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
<template>
  <div class="content pt-0">
    <div class="container pt-0">
      <div class="col-md-12">
        <div class="row">
          <router-link
            :to="{
              name: 'classView',
              params: { id: this.$route.params.class_id },
            }"
            class="btn btn-sm btn-primary"
            style="background-color: #9c27b0; border-color: #9c27b0"
          >
            <span class="material-icons"> arrow_back </span>
            Back
          </router-link>
        </div>
      </div>
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a
            class="nav-link active"
            id="pills-instruction-tab"
            data-toggle="pill"
            href="#pills-instruction"
            role="tab"
            aria-controls="pills-instruction"
            aria-selected="true"
            >Instruction</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-student-work-tab"
            data-toggle="pill"
            href="#pills-student-work"
            role="tab"
            aria-controls="pills-student-work"
            aria-selected="false"
            >Student's work</a
          >
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div
          class="tab-pane fade show active"
          id="pills-instruction"
          role="tabpanel"
          aria-labelledby="pills-instruction-tab"
        >
          <activityInstruction :activityid="this.$route.params.activity_id" />
        </div>
        <div
          class="tab-pane fade"
          id="pills-student-work"
          role="tabpanel"
          aria-labelledby="pills-student-work-tab"
        >
          <activityStudentWork :activityid="this.$route.params.activity_id" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import activityInstruction from "./activitytab/instruction.vue";
import activityStudentWork from "./activitytab/studentwork.vue";

export default {
  components: {
    activityInstruction,
    activityStudentWork,
  },
};
</script>
<style scoped>
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
  background-color: #9c27b0;
}
</style>
<template>
  <div class="content pt-0">
    <div class="container pt-0">
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
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-my-work-tab"
            data-toggle="pill"
            href="#pills-my-work"
            role="tab"
            aria-controls="pills-my-work"
            aria-selected="false"
            >My work</a
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
          <activityInstruction />
        </div>
        <div
          class="tab-pane fade"
          id="pills-student-work"
          role="tabpanel"
          aria-labelledby="pills-student-work-tab"
        >
          <activityStudentWork />
        </div>
        <div
          class="tab-pane fade"
          id="pills-my-work"
          role="tabpanel"
          aria-labelledby="pills-my-work-tab"
        >
          <activityMyWork />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import activityInstruction from "./activitytab/instruction.vue";
import activityStudentWork from "./activitytab/studentwork.vue";
import activityMyWork from "./activitytab/mywork.vue";

export default {
  components: {
    activityInstruction,
    activityStudentWork,
    activityMyWork,
  },
};
</script>
<style scoped>
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
  background-color: #9c27b0;
}
</style>
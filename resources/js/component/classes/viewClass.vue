<template>
  <div class="content pt-0">
    <div class="container pt-0">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a
            class="nav-link active"
            id="pills-home-tab"
            data-toggle="pill"
            href="#pills-home"
            role="tab"
            aria-controls="pills-home"
            aria-selected="true"
            >Discussion</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-profile-tab"
            data-toggle="pill"
            href="#pills-profile"
            role="tab"
            aria-controls="pills-profile"
            aria-selected="false"
            >Class work</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-contact-tab"
            data-toggle="pill"
            href="#pills-contact"
            role="tab"
            aria-controls="pills-contact"
            aria-selected="false"
            >People</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-leaderboard-tab"
            data-toggle="pill"
            href="#pills-leaderboard"
            role="tab"
            aria-controls="pills-leaderboard"
            aria-selected="false"
            @click="forceUpdateLeaderboard"
            >Leaderboard</a
          >
        </li>
        <li class="nav-item" role="presentation">
          <a
            class="nav-link"
            id="pills-attendance-tab"
            data-toggle="pill"
            href="#pills-attendance"
            role="tab"
            aria-controls="pills-attendance"
            aria-selected="false"
            >Attendance</a
          >
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div
          class="tab-pane fade show active"
          id="pills-home"
          role="tabpanel"
          aria-labelledby="pills-home-tab"
        >
          <discussionTab />
        </div>
        <div
          class="tab-pane fade"
          id="pills-profile"
          role="tabpanel"
          aria-labelledby="pills-profile-tab"
        >
          <classWorkTab />
        </div>
        <div
          class="tab-pane fade"
          id="pills-contact"
          role="tabpanel"
          aria-labelledby="pills-contact-tab"
        >
          <peopleTab />
        </div>
        <div
          class="tab-pane fade"
          id="pills-leaderboard"
          role="tabpanel"
          aria-labelledby="pills-leaderboard-tab"
        >
        <leaderboard-index :key="keyLeaderboard" />
        </div>
        <div
          class="tab-pane fade"
          id="pills-attendance"
          role="tabpanel"
          aria-labelledby="pills-attendance-tab"
        >
        <attendance-index />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import discussionTab from "./classtab/discussion.vue";
import classWorkTab from "./classtab/classWork.vue";
import peopleTab from "../classlist/viewClassList.vue";
import AttendanceIndex from './classtab/attendance/attendanceIndex.vue';
import LeaderboardIndex from './classtab/leaderboard/leaderboardIndex.vue';

export default {
  components: {
    discussionTab,
    classWorkTab,
    peopleTab,
    AttendanceIndex,
    LeaderboardIndex
  },
  data() {
    return {
      keyLeaderboard: 0,
    };
  },
  methods: {
    forceUpdateLeaderboard() {
      this.keyLeaderboard++;
    },
  },
};
</script>
<style scoped,
LeaderboardIndex>
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
  background-color: #9c27b0;
}
</style>
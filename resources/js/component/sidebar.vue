<template>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <router-link v-show="$isMobile()" tag="li" to="/profile" class="nav-item">
        <a class="nav-link">
          <i class="material-icons">person</i>
          <p> {{ profile_name }} </p>
        </a>
      </router-link>
      <router-link tag="li" to="/" class="nav-item" exact>
        <a class="nav-link">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </router-link>
    <router-link tag="li" to="/student" class="nav-item" v-show="side_student">
        <a class="nav-link">
            <i class="material-icons">groups</i>
            <p>Student</p>
        </a>
    </router-link>
    <router-link tag="li" to="/teacher" class="nav-item" v-show="side_teacher">
        <a class="nav-link">
            <i class="material-icons">engineering</i>
            <p>Teacher</p>
        </a>
    </router-link>
      <router-link tag="li" to="/class" class="nav-item">
        <a class="nav-link">
          <i class="material-icons">meeting_room</i>
          <p>Classes</p>
        </a>
      </router-link>
      <router-link tag="li" to="/class-list" class="nav-item" v-show="side_list">
        <a class="nav-link">
          <i class="material-icons">people</i>
          <p>List of students</p>
        </a>
      </router-link>

      <router-link tag="li" to="/video" class="nav-item" v-show="side_video">
        <a class="nav-link">
          <i class="material-icons">videocam</i>
          <p>Video Conferencing</p>
        </a>
      </router-link>
      <router-link v-show="$isMobile()" tag="li" to="#" class="nav-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <a class="nav-link">
          <i class="material-icons">logout</i>
          <p>Logout</p>
        </a>
      </router-link>
    </ul>
  </div>
</template>
<script>
export default {
  name: "sidebar",
  props: ["sessionCat"],
  data() {
    return {
      profile_name:window.sessionFullname,
      side_dashboard : true,
      side_student : true,
      side_teacher : true,
      side_list:true,
      side_video: true,
    }
  },
  created(){
    this.side_dashboard = sessionCategory == 'A' ? false : true;
    this.side_student = sessionCategory == 'A' ? true : false;
    this.side_teacher = sessionCategory == 'A' ? true : false;
    this.side_list = sessionCategory == 'A' ? true : false;
    this.side_video = sessionCategory == 'A' ? false : true;
  }
};
</script>
<style scoped>
.sidebar .nav li a,
.sidebar .nav li .dropdown-menu a {
  color: #ffffff;
}
</style>
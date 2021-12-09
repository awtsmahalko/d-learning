<template>
  <div class="wrapper">
    <div
      class="sidebar sideImage"
      data-color="purple"
      data-background-color="white"
    >
      <div class="logo">
        <a href="/" class="simple-text logo-normal"> D-Learning </a>
      </div>
      <sidebar :sessionCat="sessionCat"></sidebar>
    </div>
    <div class="main-panel">
      <nav
        class="
          navbar navbar-expand-lg navbar-transparent navbar-absolute
          fixed-top
        "
      >
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">{{ $route.meta.title }}</a>
          </div>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            aria-controls="navigation-index"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a
                  class="nav-link"
                  href="#pablo"
                  id="navbarDropdownProfile"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="material-icons">person</i> {{ profile_name }}
                  <p class="d-lg-none d-md-block">Account</p>
                </a>
                <div
                  class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="navbarDropdownProfile"
                >
                  <router-link to="/profile">
                    <a class="dropdown-item" href="#">Profile</a>
                  </router-link>
                  <div class="dropdown-divider"></div>
                  <a
                    class="dropdown-item"
                    href="#"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >Log out</a
                  >
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import sidebar from "./sidebar.vue";
export default {
  props: ["authCategory"],
  data() {
    return {
      sessionCat: "",
      profile_name:window.sessionFullname
    };
  },
  created() {
    this.sessionCat = sessionCategory == "T";
  },
  components: { sidebar },
};
</script>
<style scoped>
.sideImage {
  background-image: url("/public/material/img/login.jpg");
  background-size: cover;
  background-position: bottom center;
  background-color: rgb(28 4 32 / 75%);
  background-blend-mode: multiply;
}

.sidebar .logo .simple-text {
  color: #fff;
}
</style>

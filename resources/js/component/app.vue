<template>
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white">
      <div class="logo">
        <a href="https://creative-tim.com/" class="simple-text logo-normal">
          D-Learning
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
            <router-link tag="li" to="/" class="nav-item" exact>
              <a class="nav-link">
                  <i class="material-icons">dashboard</i>
                  <p>Dashboard</p>
              </a>
            </router-link>
            <router-link tag="li" to="/class" class="nav-item">
              <a class="nav-link">
                  <i class="material-icons">meeting_room</i>
                  <p>Classes</p>
              </a>
            </router-link>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">Title</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log out</a>
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
export default {
}
</script>
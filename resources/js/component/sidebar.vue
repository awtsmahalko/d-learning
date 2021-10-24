<template>
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

          <router-link v-show="sessionCat" tag="li" to="/class-list" class="nav-item">
            <a class="nav-link">
              <i class="material-icons">people</i>
              <p>List of students</p>
            </a>
          </router-link>

          <router-link tag="li" to="/video" class="nav-item">
            <a class="nav-link">
              <i class="material-icons">videocam</i>
              <p>Video Conferencing</p>
            </a>
          </router-link>
        </ul>
    </div>
</template>
<script>
const sessionCategory = window.sessionCategory;
export default {
    name:'sidebar',
    props:[
        'sessionCat'
    ],
    created(){
        console.log(sessionCategory);
    }
}
</script>
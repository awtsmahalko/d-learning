<template>
  <div class="content">
    <div class="container-fluid">
      <admin-class-index v-show="show_admin" />
      <user-class-index v-show="show_user" />
    </div>
  </div>
</template>
<script>
import AdminClassIndex from './adminClassIndex.vue';
import UserClassIndex from './userClassIndex.vue';
export default {
  name: "",
  components : {AdminClassIndex, UserClassIndex },
  data() {
    return {
      show_admin:false,
      show_user:false
    };
  },
  mounted() {
    this.show_admin = sessionCategory == 'A' ? true : false;
    this.show_user = sessionCategory == 'A' ? false : true;
  }
};
</script>
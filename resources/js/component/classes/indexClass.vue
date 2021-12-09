<template>
  <div class="content">
    <div class="container-fluid">
      <div v-if="category == 'A'">
        <admin-class-index />
      </div>
      <div v-else>
        <user-class-index/>
      </div>
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
      category:''
    };
  },
  mounted() {
    this.category = sessionCategory;
  }
};
</script>
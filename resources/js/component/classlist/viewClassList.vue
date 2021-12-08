<template>
  <div class="content pt-0">
    <div class="container-fluid pt-0">
      <card-title :classesId="classes_id" />
      <class-list :classesId="classes_id" />
    </div>
  </div>
</template>

<script>
import cardTitle from "../classes/cardTitle.vue";
import ClassList from './classList.vue';

export default {
  components: { cardTitle, ClassList },
  name: "view-class-list",
  data() {
    return {
      classes_id : ''
    }
  },
  created() {
    this.classes_id = this.$route.params.id;
  },
};
</script>
<style scoped>
.card.card-background .full-background {
  background-position: 50%;
  background-size: cover;
  margin-bottom: 30px;
  width: 100%;
  height: 100%;
  position: absolute;
  border-radius: 0.75rem;
}

.card .card-background {
  align-items: center;
}

.card-background {
  height: 200px;
  margin-top: 0px;
  margin-bottom: 0px;
}

.btn-width {
  width: 100%;
}

.filepond--wrapper {
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
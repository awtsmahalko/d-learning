<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card card-background">
        <div class="full-background" :style="image"></div>
        <div class="card-body pt-12">
          <h2 class="text-white font-weight-bold pt-2">
            {{ classData.name }}
          </h2>
          <p class="text-white">
            Class code: <b>{{ classData.code }}</b>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "card-title",
  props: ["classesId"],
  data() {
    return {
      classData: {
        name: "",
        code: "",
      },
      image: "background-image:url(/public/material/img/class.jpg)",
    };
  },
  created() {
    this.fetchTitleData();
  },
  methods: {
    fetchTitleData() {
      this.axios.get(baseUrl + `/api/class/${this.classesId}`).then((res) => {
        this.classData = res.data;
      });
    },
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
</style>
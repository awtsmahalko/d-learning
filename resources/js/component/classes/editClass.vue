<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Create Class</h4>
              <p class="card-category">Complete your class details</p>
            </div>
            <div class="card-body">
              <form @submit.prevent="update">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group bmd-form-group">
                      <label>Code</label>
                      <input
                        v-model="clas.code"
                        type="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group bmd-form-group">
                      <label>Name</label>
                      <input
                        v-model="clas.name"
                        type="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">
                  <span class="material-icons">edit</span> Update Class
                </button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "edit-class",
  data() {
    return {
      clas: {},
    };
  },
  created() {
    this.axios.get(`/api/class/${this.$route.params.id}`).then((res) => {
      this.clas = res.data;
    });
  },
  methods: {
    async update() {
      this.axios
        .patch(`/api/class/${this.$route.params.id}`, this.clas)
        .then((response) => {
          this.$router.push({ name: "class" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
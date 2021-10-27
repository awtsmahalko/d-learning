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
              <form @submit.prevent="create">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group bmd-form-group">
                      <label class="bmd-label-floating">Code</label>
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
                      <label class="bmd-label-floating">Name</label>
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
                  <span class="material-icons">add_circle_outline</span> Add
                  Class
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
  name: "add-class",
  data() {
    return {
      clas: {
        user_id: sessionUserId,
        code: "",
        name: "",
      },
    };
  },
  methods: {
    async create() {
      await this.axios
        .post(baseUrl + "/api/class", this.clas)
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
<template>
  <div class="content">
    <div class="container-fluid pt-0">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-background">
            <div
              class="full-background"
              style="
                background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80');
              "
            ></div>
            <div class="card-body pt-12">
              <h3 class="text-white font-weight-normal">PROGRAMMING 1</h3>
              <p style="color: #fff">Class code: <b>0A9SD8</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submitPost">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group bmd-form-group">
                      <!-- <label>Share to your class</label> -->
                      <textarea
                        v-model="post.description"
                        id="summernote"
                        class="form-control"
                        required
                      ></textarea>
                    </div>
                  </div>
                  <hr />
                  <div class="col-md-12" style="border-top: 2px solid #ddd">
                    <div class="card">
                      <div
                        class="card-horizontal"
                        style="display: flex; flex-direction: row"
                      >
                        <img
                          class=""
                          src="http://via.placeholder.com/300x180"
                          alt="Card image cap"
                          style="
                            width: 120px;
                            object-fit: cover;
                            border-top-left-radius: 3px;
                            border-bottom-left-radius: 3px;
                          "
                        />

                        <div class="card-body" style="padding: 11px">
                          <div
                            class="d-flex flex-row"
                            style="justify-content: space-between"
                          >
                            <div>
                              <h5 class="card-title">
                                <b>test_attachment_for_class.jpg</b>
                              </h5>
                              <p class="card-text text-muted">Image</p>
                            </div>
                            <div
                              style="
                                display: flex;
                                align-items: center;
                                padding: 11px;
                              "
                            >
                              <h4><b>X</b></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary">
                  <span class="material-icons">attach_file</span> ATTACH
                </button>

                <div class="btn-group" role="group">
                  <button
                    id="btnGroupDrop1"
                    type="button"
                    class="btn btn-sm btn-primary dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span class="material-icons">edit</span> POST
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="#">Discussion</a>
                    <a class="dropdown-item" href="#">Activity</a>
                  </div>
                </div>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
          <div v-if="posts.length > 0">
            <div v-for="(post, key) in posts" :key="key" class="card">
              <div class="card-header">
                <h4 class="card-title">
                  <b>{{ post.user.fname }}</b>
                </h4>
                <small class="card-category">{{ post.created_at }}</small>
              </div>
              <div class="card-body" style="padding-top: 0px">
                <p style="color: #5a5a5a">{{ post.description }}</p>

                <div class="col-md-12" style="border-top: 0px solid #ddd">
                  <div class="row">
                    <div class="card" style="margin: 5px">
                      <div
                        class="card-horizontal"
                        style="display: flex; flex-direction: row"
                      >
                        <img
                          class=""
                          src="http://via.placeholder.com/300x180"
                          alt="Card image cap"
                          style="
                            width: 120px;
                            object-fit: cover;
                            border-top-left-radius: 3px;
                            border-bottom-left-radius: 3px;
                          "
                        />

                        <div class="card-body" style="padding: 11px">
                          <div
                            class="d-flex flex-row"
                            style="justify-content: space-between"
                          >
                            <div>
                              <h5 class="card-title">
                                <b>test_attachment_for_class.jpg</b>
                              </h5>
                              <p class="card-text text-muted">Image</p>
                            </div>
                            <div
                              style="
                                display: flex;
                                align-items: center;
                                padding: 11px;
                              "
                            >
                              <h4><b>X</b></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card" style="margin: 5px">
                      <div
                        class="card-horizontal"
                        style="display: flex; flex-direction: row"
                      >
                        <img
                          class=""
                          src="http://via.placeholder.com/300x180"
                          alt="Card image cap"
                          style="
                            width: 120px;
                            object-fit: cover;
                            border-top-left-radius: 3px;
                            border-bottom-left-radius: 3px;
                          "
                        />

                        <div class="card-body" style="padding: 11px">
                          <div
                            class="d-flex flex-row"
                            style="justify-content: space-between"
                          >
                            <div>
                              <h5 class="card-title">
                                <b>test_attachment_for_class.jpg</b>
                              </h5>
                              <p class="card-text text-muted">Image</p>
                            </div>
                            <div
                              style="
                                display: flex;
                                align-items: center;
                                padding: 11px;
                              "
                            >
                              <h4><b>X</b></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Disscusion</li>
                <li class="list-group-item">Activities</li>
                <li class="list-group-item">People</li>
                <li class="list-group-item">Files</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "view-class",
  data() {
    return {
      posts: [],
      post: {
        user_id: sessionUserId,
        class_id: "",
        description: "",
      },
    };
  },
  created() {
    this.post.class_id = this.$route.params.id;
  },
  mounted() {
    this.getPosts();
    $("#summernote").summernote({
      placeholder: "Share to your class",
      toolbar: [
        ["font", ["bold", "underline", "clear"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
      ],
    });
  },
  methods: {
    async getPosts() {
      await this.axios
        .get("/api/post", {
          params: {
            user_id: sessionUserId,
            class_id: this.$route.params.id,
          },
        })
        .then((response) => {
          this.posts = response.data;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.posts = [];
        });
    },
    submitPost() {
      this.axios
        .post("/api/post", this.post)
        .then((response) => {
          console.log(response.data);
          this.post.description = "";
          this.getPosts();
        })
        .catch((error) => {
          console.log(error);
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
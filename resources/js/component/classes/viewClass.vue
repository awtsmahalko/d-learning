<template>
  <div class="content pt-0">
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
              <h2 class="text-white font-weight-bold pt-2">
                {{ classData.name }}
              </h2>
              <p style="color: #fff">
                Class code: <b>{{ classData.code }}</b>
              </p>
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
                        class="form-control summernote"
                        id="summernote"
                        required
                      ></textarea>
                    </div>
                  </div>
                  <div class="col-md-12" style="border-top: 2px solid #ddd">
                    <div class="row">
                      <div class="col-md-12 mt-1">
                        <file-pond
                          name="test"
                          ref="pond"
                          label-idle="Drop attachment here..."
                          v-bind:allow-multiple="true"
                          :files="myFiles"
                          :server="{ process }"
                          v-on:init="handleFilePondInit"
                          @processfile="onProcessFile"
                          @addfile="onAddFile"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">
                  <span class="material-icons">edit</span> POST
                </button>
              </form>
            </div>
          </div>
          <div v-if="posts.length > 0">
            <div v-for="(post, key) in posts" :key="key" class="card">
              <postContent
                :userposted="post.user.fname"
                :dateposted="post.created_at"
                :descriptionposted="post.description"
              />
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
import postAttachment from "./post/postAttachment.vue";
import postContent from "./post/postContent.vue";

// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Create component
const FilePond = vueFilePond();

export default {
  name: "view-class",
  data() {
    return {
      classData: {},
      posts: [],
      post: {
        user_id: sessionUserId,
        class_id: "",
        description: "<p><br></p>",
      },
      myFiles: [],
    };
  },
  created() {
    this.post.class_id = this.$route.params.id;

    this.axios.get(`/api/class/${this.$route.params.id}`).then((res) => {
      this.classData = res.data;
    });
  },
  mounted() {
    this.getPosts();
    const vm = this;
    const options = {
      placeholder: "Share to your class",
      toolbar: [
        ["font", ["bold", "underline", "clear"]],
        ["color", ["color"]],
      ],
      disableDragAndDrop: true,
      spellCheck: true,
    };

    options.callbacks = {
      onChange(contents) {
        vm.post.description = contents;
      },
    };

    $("textarea#summernote").summernote(options);
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
          // console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.posts = [];
        });
    },
    submitPost() {
      if (this.post.description != "<p><br></p>") {
        this.axios
          .post("/api/post", this.post)
          .then((response) => {
            $("textarea#summernote").summernote("code", "<p><br></p>");
            this.getPosts();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alert("Compose anything to share to the class");
      }
    },
    handleFilePondInit: function () {
      console.log("FilePond has initialized");

      // this.$refs.pond.setOptions({
      //   server: {
      //     url: "/post/uploadPostAttachment",
      //     headers: {
      //       "X-CSRF-TOKEN": "{{ csrf_token() }}",
      //     },
      //   },
      // });

      // FilePond instance methods are available on `this.$refs.pond`
    },
    onProcessFile(error, file) {
      console.log("file processed", {
        error,
        file,
      });

      // // set data
      // const formData = new FormData();
      // formData.append("file", file, file.name);

      // this.axios
      //   .post("/api/uploadPostAttachment", this.post)
      //   .then((response) => {
      //     // passing the file id to FilePond
      //     // load(response.data.data.id);
      //     console.log(response.data.data.id);
      //   })
      //   .catch((error) => {
      //     console.log(error);
      //   });
    },
    onAddFile(error, file) {
      console.log("file added", { error, file });
    },
    process(fieldName, file, metadata, load, error, progress, abort) {
      var self = this;

      // set data
      const formData = new FormData();
      formData.append("file", file, file.name);

      this.axios
        .get("/api/uploadPostAttachment", formData)
        .then((response) => {
          console.log(response);
          load(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // process: {
    //   url: "./process",
    //   method: "POST",
    //   withCredentials: false,
    //   headers: {
    //     "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //   },
    //   timeout: 7000,
    //   onload: null,
    //   onerror: null,
    // },
  },
  components: {
    postAttachment,
    postContent,
    FilePond,
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
</style>
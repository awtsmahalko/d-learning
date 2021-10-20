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
                          name="file"
                          ref="pond"
                          label-idle="Drop attachment here..."
                          v-bind:allow-multiple="true"
                          :files="myFiles"
                          :server="server"
                          v-on:init="handleFilePondInit"
                        />
                        <!-- 
                          v-on:init="handleFilePondInit"
                          @processfile="onProcessFile"
                          @addfile="onAddFile"
                         -->
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
                :postsAttachments="post.post_attachments"
                :classCode="classData.code"
                :postId="post.id"
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

const options = {
  placeholder: "Share to your class",
  toolbar: [
    // ["font", ["bold", "underline", "clear"]],
    // ["color", ["color"]],
    ["style", ["style"]],
    ["font", ["bold", "underline", "clear"]],
    ["para", ["ul", "ol", "paragraph"]],
  ],
  disableDragAndDrop: true,
  spellCheck: true,
};

export default {
  name: "view-class",
  data() {
    return {
      classData: {},
      posts: [],
      post: {
        user_id: sessionUserId,
        class_id: "",
        description: "<br>",
      },
      myFiles: [],
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("classId", this.post.class_id);
          this.axios({
            method: "POST",
            url: "/api/uploadPostAttachment",
            data: formData,
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
            .then((response) => {
              load(response.data);
            })
            .catch(() => {
              error();
            });
        },
        revert: (uniqueFileId, load, error) => {
          this.axios({
            method: "DELETE",
            url: "/api/deletePostAttachment",
            data: {
              file: uniqueFileId,
              classId: this.post.class_id,
            },
          })
            .then((response) => {
              load();
            })
            .catch(() => {
              error();
            });

          // Can call the error method if something is wrong, should exit after
          error("oh my goodness");

          // Should call the load method when done, no parameters required
          load();
        },
      },
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

    options.callbacks = {
      onChange(contents) {
        vm.post.description = contents;
      },
    };

    $("textarea#summernote").summernote(options);
    $("textarea#summernote").summernote("code", "<br>");
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
          // this.postsAttachments = response.data.post_attachments;
          // console.log(this.postsAttachments);
        })
        .catch((error) => {
          console.log(error);
          this.posts = [];
        });
    },
    submitPost() {
      console.log(this.post.description);
      if (this.post.description != "<br>") {
        var postFileValue = [];
        $("input[name='file']").each(function () {
          postFileValue.push($(this).val());
        });

        this.axios
          .post("/api/post", {
            postData: this.post,
            postAttachData: postFileValue,
          })
          .then((response) => {
            this.$refs.pond.removeFiles();
            $("textarea#summernote").summernote("destroy");
            $("textarea#summernote").summernote(options);
            $("textarea#summernote").summernote("code", "<br>");
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
      // example of instance method call on pond reference
      this.$refs.pond.getFiles();
      // console.log(this.$refs.pond.getFiles());
    },
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

.filepond--wrapper {
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
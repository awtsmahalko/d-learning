<template>
  <div>
    <div class="card-header">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex">
            <div class="flex-shrink-0" style="padding: 11px">
              <img
                class="avatar rounded-circle me-3"
                :src="asset(userpostedAvatar)"
                :alt="userpostedAvatar"
                style="width: 40px; height: 40px"
              />
            </div>
            <div
              style="
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 100%;
              "
            >
              <div class="mx-2" style="display: flex; flex-direction: column">
                <h5 class="card-title mb-0">
                  <b id="post-user">{{ userposted }}</b>
                </h5>
                <small class="card-category mt-0 text-muted">
                  {{ new Date(dateposted).toLocaleString() }}
                </small>
              </div>
              <div v-show="is_teacher">
                <a class="attachment-remove" @click="deletePost(postId)">
                  <i class="material-icons attachment-remove-icon">delete</i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body" style="padding-top: 0px">
      <p class="post-description" v-html="descriptionposted"></p>
      <postContentAttachment
        :postsAttachments="postsAttachments"
        :classCode="classCode"
      />
    </div>

    <!-- comments -->
    <postComment
      :comments="this.comments"
      :classCode="classCode"
      :userpostedId="userpostedId"
    />
    <!-- comments -->

    <div class="card-footer mx-0 px-3 py-0 my-0" style="justify-content: start">
      <button class="btn btn-sm btn-primary" @click="openCommentModal(postId)">
        <i class="material-icons text-sm">chat</i> Add comment
      </button>
    </div>

    <!-- modal -->
    <div
      class="modal fade"
      :id="'newCommentModal' + postId"
      role="dialog"
      aria-labelledby="newCommentModal"
      aria-hidden="true"
    >
      <div
        class="modal-dialog"
        role="document"
        style="max-width: 50% !important"
      >
        <div class="modal-content">
          <form id="modal_newComment" @submit.prevent="sendComment()">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="newCommentModal">New Comment</h5>
              <input type="hidden" id="hidden_post_id" />
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body py-0">
              <div class="row">
                <div
                  class="col-md-12 py-4 mt-2"
                  style="border-left: 1px solid #ddd"
                >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="message"
                        >Your comment <span style="color: red">*</span></label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="message"
                        v-model="comment.message"
                      />
                    </div>
                  </div>

                  <div class="col-md-12 mt-1">
                    <file-pond
                      name="file"
                      ref="napond"
                      label-idle="Drop attachment here..."
                      v-bind:allow-multiple="true"
                      :files="commentFiles"
                      :server="server"
                      v-on:init="handleFilePondInit"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                Post comment
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- end modal -->
  </div>
</template>
<script>
import postContentAttachment from "./postAttachment.vue";
import postComment from "./postComment.vue";

// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Create component
const FilePond = vueFilePond();

export default {
  props: [
    "userpostedId",
    "userpostedAvatar",
    "userposted",
    "dateposted",
    "descriptionposted",
    "postsAttachments",
    "classCode",
    "postId",
  ],
  components: {
    postContentAttachment,
    postComment,
  },
  data() {
    return {
      is_teacher: false,
      comments: [],
      commentFiles: [],
      componentKey: 0,
      comment: {
        user_id: sessionUserId,
        post_id: "",
        message: "",
        commentedFiles: [],
        classCode: "",
      },
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("classCode", this.classCode);
          // console.log(this.$route.params.activity_id);
          this.axios({
            method: "POST",
            url: baseUrl + "/api/post/comment/uploadCommentAttachment",
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
            url: baseUrl + "/api/post/comment/revertCommentAttachment",
            data: {
              file: uniqueFileId,
              classCode: this.classCode,
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
    this.comment.post_id = this.postId;
    this.comment.classCode = this.classCode;
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.getComment();
  },
  methods: {
    async getComment() {
      await this.axios
        .get(baseUrl + "/api/post/comment", {
          params: {
            user_id: sessionUserId,
            post_id: this.comment.post_id,
          },
        })
        .then((response) => {
          this.comments = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.posts = [];
        });
    },
    sendComment() {
      if (this.comment.message != "") {
        var pcFileValue = [];
        $("input[name='file']").each(function () {
          pcFileValue.push($(this).val());
        });

        var postid = $("#hidden_post_id").val();
        this.comment.commentedFiles = pcFileValue;
        this.comment.post_id = postid;

        this.axios
          .post(baseUrl + "/api/post/comment/add", this.comment)
          .then((response) => {
            this.getComment();
            $("#newCommentModal" + postid).modal("hide");
            this.comment.message = "";
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alertMe("Compose a message to comment.");
      }
    },
    deletePost(id) {
      var _this = this;
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        showLoaderOnConfirm: true,
        preConfirm: function () {
          return new Promise(function (resolve) {
            _this.axios
              .post(baseUrl + "/api/post/delete", {
                post_id: id,
              })
              .then((response) => {
                _this.$parent.getPosts();
                success_delete();
              })
              .catch((error) => {
                console.log(error);
              });
          });
        },
        allowOutsideClick: false,
      });
    },
    reloadFun() {
      this.$parent.getPosts();
    },
    openCommentModal(postid) {
      $("#hidden_post_id").val(postid);
      $("#newCommentModal" + postid).modal("show");
    },
    handleFilePondInit: function () {
      this.$refs.napond.getFiles();
    },
    asset(path) {
      return imgUrl + path;
    },
  },
};
</script>
<style scoped>
.post-description {
  color: #5a5a5a;
  font-size: 16px;
}

.dropdown-toggle::after {
  content: none !important;
}

.post-avatar {
  border: 1px solid #c4c0c0;
  border-radius: 3px;
}

.card-footer {
  border-top: 1px solid #ddd !important;
}

.attachment-remove {
  cursor: default;
}

.attachment-remove-icon {
  font-size: 1.1rem;
  color: #f44336;
  padding: 0.40625rem 1.25rem;
}
</style>
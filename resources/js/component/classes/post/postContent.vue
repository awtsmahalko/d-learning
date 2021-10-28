<template>
  <div>
    <div class="card-header">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex">
            <div class="flex-shrink-0" style="margin-top: 4px">
              <img
                alt="Image placeholder"
                class="avatar rounded-circle me-3"
                src="http://via.placeholder.com/300x180"
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
              <div>
                <button
                  class="btn btn-sm btn-secondary dropdown-toggle"
                  id="navbarDropdownMenuLink1"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i
                    class="fa fa-ellipsis-v text-lg text-muted"
                    aria-hidden="true"
                  ></i>
                </button>
                <div
                  class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3"
                  aria-labelledby="navbarDropdownMenuLink1"
                  style="right: auto !important; left: 0 !important"
                >
                  <a class="dropdown-item" href="#">Edit</a>
                  <a class="dropdown-item" href="#">Delete</a>
                </div>
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
    <postComment :comments="this.comments" />
    <!-- comments -->

    <div class="card-footer mx-0 px1">
      <div class="mx-3" style="width: 100%">
        <div class="d-flex">
          <div class="flex-shrink-0">
            <img
              alt="Image placeholder"
              class="avatar rounded-circle me-3 mx-1"
              src="http://via.placeholder.com/300x180"
              style="width: 40px; height: 40px"
            />
          </div>
          <div class="flex-grow-1 my-auto" style="width: 100%">
            <div class="input-group input-group-static px-2">
              <textarea
                class="form-control"
                placeholder="Write your comment"
                v-model="comment.message"
                rows="1"
                spellcheck="false"
              ></textarea>
            </div>
          </div>
          <button class="btn btn-sm btn-primary" v-on:click="sendComment">
            <i class="material-icons text-sm">send</i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import postContentAttachment from "./postAttachment.vue";
import postComment from "./postComment.vue";

export default {
  props: [
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
      comments: [],
      comment: {
        user_id: sessionUserId,
        post_id: "",
        message: "",
      },
    };
  },
  created() {
    this.comment.post_id = this.postId;
  },
  mounted() {
    this.getComment();
  },
  methods: {
    async getComment() {
      await this.axios
        .get(baseUrl + "/api/post/comment", {
          params: {
            user_id: sessionUserId,
            post_id: this.postId,
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
        this.axios
          .post(baseUrl + "/api/post/comment/add", this.comment)
          .then((response) => {
            this.getComment();
            this.comment.message = "";
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
      }
    },
  },
};
</script>
<style scoped>
.post-description {
  color: #5a5a5a;
  font-weight: 410;
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
</style>
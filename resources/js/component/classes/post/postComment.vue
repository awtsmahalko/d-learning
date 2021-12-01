<template>
  <div class="card-footer mx-0 px-1" v-if="comments.length > 0">
    <div style="width: 100%">
      <div class="col-md-12">
        <h6>
          <b>{{ comments.length }}</b> class comments
        </h6>
      </div>
      <!-- <div v-if="posts.length > 0">
            <div v-for="(comment, key) in comments" :key="key" class="card"> -->
      <!-- start loop -->
      <!-- start loop -->
      <div class="col-md-12 mt-3" v-for="comment in comments" :key="comment.id">
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
              width: 100%;
            "
          >
            <div
              class="mx-2"
              style="display: flex; flex-direction: column; width: 100%"
            >
              <h6 class="card-title mb-0">
                <b id="post-user">{{ comment.user.fname }}</b>

                <small class="card-category mt-0 text-muted">
                  {{ new Date(comment.created_at).toLocaleString() }}
                </small>
              </h6>
              <p class="comment mt-0" v-html="comment.message"></p>

              <!-- attachments -->
              <div
                v-show="comment.comment_attachment.length > 0 ? true : false"
                class="col-md-12"
                style="border-top: 1px solid #ddd"
              >
                <div class="row">
                  <!-- loop attachments -->
                  <div
                    class="col-md-6"
                    v-for="commentFile in comment.comment_attachment"
                    :key="commentFile.id"
                  >
                    <div class="row">
                      <div
                        class="card file-attachment"
                        style="margin: 3px; margin-top: 5px"
                      >
                        <div
                          class="col-md-12"
                          style="
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            justify-content: space-between;
                            padding: 0px;
                          "
                        >
                          <div
                            class="card-icon p-0"
                            style="border-right: 1px solid #c4c0c0"
                          >
                            <img
                              :src="asset(commentFile.thumbnail)"
                              :alt="commentFile.thumbnail"
                              style="
                                width: 92px;
                                height: 64px;
                                object-fit: cover;
                                border-top-left-radius: 3px;
                                border-bottom-left-radius: 3px;
                                background-color: #ddd;
                              "
                            />
                          </div>
                          <div
                            class="pl-2"
                            style="
                              display: flex;
                              flex-direction: column;
                              width: 80%;
                            "
                          >
                            <h4
                              class="card-title mb-0"
                              style="
                                text-overflow: ellipsis;
                                width: 100%;
                                white-space: nowrap;
                                overflow: hidden;
                                margin: 0px;
                                font-size: 14px;
                              "
                              data-toggle="tooltip"
                              data-placement="bottom"
                              title="test"
                              @click="downloadCommentAttachment(commentFile.id)"
                            >
                              <b id="post-user">{{ commentFile.filename }}</b>
                            </h4>
                            <small class="card-category mt-0 text-muted">
                              {{ commentFile.filetype }}
                            </small>
                          </div>
                          <div
                            class="ms-auto"
                            v-show="
                              comment.user_id == sessionUser - sessionUser
                                ? true
                                : false
                            "
                          >
                            <a
                              class="attachment-remove"
                              @click="deleteCommentAttachment(commentFile.id)"
                            >
                              <i class="material-icons attachment-remove-icon"
                                >close</i
                              >
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /loop attachments -->
                </div>
              </div>
              <!-- /attachments -->
            </div>
            <div>
              <!-- test -->
            </div>
          </div>
        </div>
      </div>
      <!-- end loop -->
    </div>
  </div>
</template>
<script>
export default {
  props: ["comments", "classCode", "userpostedId"],
  data() {
    return {
      sessionUser: sessionUserId,
    };
  },
  methods: {
    downloadCommentAttachment(commentFile_id) {
      window.open(
        baseUrl +
          "/api/post/comment/downloadCommentAttachment/" +
          this.classCode +
          "/" +
          commentFile_id,
        "_blank"
      );
    },
    deleteCommentAttachment(commentFile_id) {
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
            _this
              .axios({
                method: "DELETE",
                url: baseUrl + "/api/post/comment/deleteCommentAttachment",
                data: {
                  classCode: _this.classCode,
                  commentFile_id: commentFile_id,
                },
              })
              .then((response) => {
                _this.$parent.getComment();
                success_delete();
              })
              .catch(() => {
                error();
              });
          });
        },
        allowOutsideClick: false,
      });
    },
    asset(path) {
      return imgUrl + path;
    },
  },
};
</script>
<style scoped>
.file-attachment {
  border: 1px solid #c4c0c0;
  margin: 5px;
}

.comment {
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 2px;
  white-space: break-spaces;
}

.dropdown-toggle::after {
  content: none !important;
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
<template>
  <div
    class="container px-0"
    v-if="postsAttachments.length > 0"
    style="width: 100%"
  >
    <div class="row">
      <div
        class="col-md-6"
        v-for="(attachment, key) in postsAttachments"
        :key="key"
      >
        <div class="card file-attachment" style="margin: 3px">
          <div class="row">
            <div
              class="col-md-12"
              style="
                display: flex;
                width: 100px;
                flex-direction: row;
                align-items: center;
              "
            >
              <div
                class="card-icon p-0"
                style="border-right: 1px solid #c4c0c0"
              >
                <img
                  :src="asset(attachment.thumbnail)"
                  :alt="attachment.filename"
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
              <div class="pl-2" style="display: flex; flex-direction: column">
                <h4
                  class="card-title mb-0"
                  style="
                    text-overflow: ellipsis;
                    width: 260px;
                    white-space: nowrap;
                    overflow: hidden;
                    margin: 0px;
                    font-size: 14px;
                  "
                  data-toggle="tooltip"
                  data-placement="bottom"
                  :title="attachment.filename"
                  @click="downloadFile(attachment.id)"
                >
                  <b id="post-user">{{ attachment.filename }}</b>
                </h4>
                <small class="card-category mt-0 text-muted">
                  {{ attachment.filetype }}
                </small>
              </div>
              <div class="ms-auto" v-show="is_teacher">
                <a
                  class="attachment-remove"
                  @click="deletePostAttachment(attachment.id)"
                >
                  <i class="material-icons attachment-remove-icon">close</i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["postsAttachments", "classCode"],
  data() {
    return {
      is_teacher: false,
    };
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
  },
  methods: {
    deletePostAttachment(attachment_id) {
      this.axios({
        method: "DELETE",
        url: baseUrl + "/api/post/deleteAttachment",
        data: {
          attachment_id: attachment_id,
        },
      })
        .then((response) => {
          this.$parent.reloadFun();
        })
        .catch(() => {
          error();
        });
    },
    downloadFile(post_attachment_id) {
      window.open(
        baseUrl +
          "/api/class/post/downloadAttachment/" +
          this.classCode +
          "/" +
          post_attachment_id,
        "_blank"
      );
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

.post-description {
  color: #5a5a5a;
  font-weight: 410;
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

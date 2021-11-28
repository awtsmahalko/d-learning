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
                v-show="1 == 0 ? true : false"
                class="col-md-12"
                style="border-top: 1px solid #ddd"
              >
                <div class="row">
                  <!-- loop attachments -->
                  <div class="col-md-6">
                    <div class="row">
                      <div
                        class="card file-attachment"
                        style="margin: 3px; margin-top: 5px"
                      >
                        <div
                          class="col-md-12 py-2"
                          style="
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            justify-content: space-between;
                          "
                        >
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
                              @click="downloadCommentAttachment(2)"
                            >
                              <b id="post-user">{{ "name" }}</b>
                            </h4>
                            <small class="card-category mt-0 text-muted">
                              {{ "type" }}
                            </small>
                          </div>
                          <div class="ms-auto">
                            <a
                              class="attachment-remove"
                              @click="deleteClassworkMaterial(3)"
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
  props: ["comments"],
};
</script>
<style scoped>
.comment {
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 2px;
  white-space: break-spaces;
}

.dropdown-toggle::after {
  content: none !important;
}
</style>
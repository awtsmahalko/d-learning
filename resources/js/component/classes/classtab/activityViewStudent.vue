<template>
  <div class="content pt-0">
    <div class="container pt-0">
      <div class="col-md-12">
        <router-link
          :to="{
            name: 'classView',
            params: { id: this.$route.params.class_id },
          }"
          class="btn btn-sm btn-primary"
          style="background-color: #9c27b0; border-color: #9c27b0"
        >
          <span class="material-icons"> arrow_back </span>
          Back
        </router-link>
      </div>
      <div class="row">
        <div class="col-md-8">
          <activityInstruction :activityid="this.$route.params.activity_id" />
        </div>
        <div class="col-md-4">
          <div class="container mt-3">
            <div class="col-md-12">
              <div class="row">
                <!-- start loop -->
                <div class="card my-2">
                  <div style="width: 100%">
                    <div class="col-md-12 pt-2">
                      <div class="d-flex">
                        <div
                          style="
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                            align-items: baseline;
                            width: 100%;
                          "
                        >
                          <div
                            class="mx-2 py-2"
                            style="
                              display: flex;
                              flex-direction: column;
                              width: 100%;
                            "
                          >
                            <h3 class="card-title mb-0">
                              <b class="comment" id="post-user">Your work</b>
                            </h3>
                            <div class="col-md-12 px-0">
                              <div class="row">
                                <div
                                  class="col-md-12"
                                  style="border-bottom: 2px solid #ddd"
                                >
                                  <file-pond
                                    name="file"
                                    ref="swpond"
                                    label-idle="Drop your work here..."
                                    v-bind:allow-multiple="true"
                                    :files="studentActivityFiles"
                                    :server="server"
                                    v-on:init="handleFilePondInit"
                                  />
                                </div>
                                <div
                                  class="card file-attachment"
                                  style="margin: 3px; margin-top: 5px"
                                >
                                  <div class="row">
                                    <div
                                      class="col-md-12 py-2"
                                      style="
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
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
                                        >
                                          <b id="post-user">attachment name</b>
                                        </h4>
                                        <small
                                          class="card-category mt-0 text-muted"
                                        >
                                          PNG
                                        </small>
                                      </div>
                                      <div class="ms-auto">
                                        <a class="attachment-remove">
                                          <i
                                            class="
                                              material-icons
                                              attachment-remove-icon
                                            "
                                            >close</i
                                          >
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              style="
                                display: flex;
                                flex-direction: row;
                                justify-content: space-between;
                                align-items: center;
                                width: 100%;
                                margin-top: 12px;
                              "
                            >
                              <button
                                class="btn btn-sm btn-success"
                                style="width: 100%"
                              >
                                Submit
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end loop -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import activityInstruction from "./activitytab/instruction.vue";
// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Create component
const FilePond = vueFilePond();

export default {
  name: "student-work",
  data() {
    return {
      is_teacher: false,
      classData: {},
      studentActivityFiles: [],
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("classId", this.$route.params.class_id);
          formData.append("activityId", this.$route.params.activity_id);
          formData.append("userId", this.session.user_id);
          this.axios({
            method: "POST",
            url: baseUrl + "/api/class/activity/uploadStudentWork",
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
          // this.axios({
          //   method: "DELETE",
          //   url: baseUrl + "/api/deletePostAttachment",
          //   data: {
          //     file: uniqueFileId,
          //     classId: this.newActivity.class_id,
          //   },
          // })
          //   .then((response) => {
          //     load();
          //   })
          //   .catch(() => {
          //     error();
          //   });
          // // Can call the error method if something is wrong, should exit after
          // error("oh my goodness");
          // // Should call the load method when done, no parameters required
          // load();
        },
      },
    };
  },
  created() {
    // this.newActivity.class_id = this.$route.params.id;
    // this.axios
    //   .get(baseUrl + `/api/class/${this.$route.params.id}`)
    //   .then((res) => {
    //     this.classData = res.data;
    //   });
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
  },
  methods: {
    submitPost() {
      var swFileValue = [];
      $("input[name='file']").each(function () {
        swFileValue.push($(this).val());
      });
      console.log(swFileValue);

      //   this.axios
      //     .post(baseUrl + "/api/post", {
      //       postData: this.post,
      //       postAttachData: swFileValue,
      //     })
      //     .then((response) => {
      //       this.$refs.swpond.removeFiles();
      //     })
      //     .catch((error) => {
      //       console.log(error);
      //     });
    },
    handleFilePondInit: function () {
      // example of instance method call on pond reference
      this.$refs.swpond.getFiles();
    },
  },
  components: {
    activityInstruction,
    FilePond,
  },
};
</script>
<style scoped>
.comment {
  margin-bottom: 2px;
  /* white-space: break-spaces; */
}

.dropdown-toggle::after {
  content: none !important;
}

.normalText {
  font-weight: 400;
}

.additionalLabel {
  color: #505050;
  font-weight: 400;
}

.instructionDescription {
  color: #505050;
  font-weight: 400;
  font-size: 14px;
}

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
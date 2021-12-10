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
                    <div class="col-md-12 p-3">
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
                            style="
                              display: flex;
                              flex-direction: column;
                              width: 100%;
                            "
                          >
                            <h3 class="card-title mb-0">
                              <b class="comment" id="post-user">Your work</b>
                            </h3>
                            <form @submit.prevent="submitWork">
                              <div class="col-md-12 px-0">
                                <div
                                  class="col-md-12"
                                  style="border-bottom: 2px solid #ddd"
                                >
                                  <input
                                    v-show="$isMobile()"
                                    type="file"
                                    name="normalFiles"
                                    id="normalFiles"
                                    ref="normalFilesRefs"
                                    multiple
                                    v-on:change="handleFileUploads()"
                                  />
                                  <file-pond
                                    v-show="
                                      $isMobile()
                                        ? false
                                        : studentWork.length > 0
                                        ? studentWork[0].status != 'S'
                                        : true
                                    "
                                    name="file"
                                    ref="swpond"
                                    label-idle="Drop your work here..."
                                    v-bind:allow-multiple="true"
                                    credits="false"
                                    :files="studentActivityFiles"
                                    :server="server"
                                    v-on:init="handleFilePondInit"
                                  />
                                </div>
                                <div
                                  class="card file-attachment"
                                  style="margin: 3px; margin-top: 5px"
                                  v-for="(sw, key) in studentWork"
                                  :key="key"
                                >
                                  <div
                                    class="col-md-12"
                                    style="
                                      display: flex;
                                      flex-direction: row;
                                      align-items: center;
                                      padding: 0px;
                                    "
                                  >
                                    <div
                                      class="card-icon p-0"
                                      style="border-right: 1px solid #c4c0c0"
                                    >
                                      <img
                                        :src="asset(sw.thumbnail)"
                                        :alt="sw.thumbnail"
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
                                        width: 46%;
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
                                        @click="downloadFile(sw.id)"
                                      >
                                        <b id="post-user">{{ sw.filename }}</b>
                                      </h4>
                                      <small
                                        class="card-category mt-0 text-muted"
                                      >
                                        {{ sw.filetype }}
                                      </small>
                                    </div>
                                    <div class="ms-auto">
                                      <a
                                        class="attachment-remove"
                                        v-show="
                                          sw.status == 'S'
                                            ? (showRemoveFile = false)
                                            : (showRemoveFile = true)
                                        "
                                        @click="deleteWork(sw.id)"
                                      >
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
                              <div
                                v-show="
                                  studentWork.length > 0
                                    ? studentWork[0].status == 'C'
                                      ? true
                                      : false
                                    : true
                                "
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
                                  type="submit"
                                  class="btn btn-sm btn-success"
                                  style="width: 100%"
                                >
                                  Submit
                                </button>
                              </div>
                            </form>
                            <div
                              v-show="
                                studentWork.length > 0
                                  ? studentWork[0].status == 'S'
                                    ? studentScore == null
                                      ? true
                                      : false
                                    : false
                                  : false
                              "
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
                                class="btn btn-sm btn-danger"
                                style="width: 100%"
                                v-on:click="unsubmitWork"
                              >
                                Unsubmit {{ studentScore }}
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
      showRemoveFile: true,
      isMobile: this.$isMobile(),
      classData: {},
      studentScore: [],
      studentWork: [],
      studentActivityFiles: [],
      normalFiles: [],
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
    this.getStudentWork();
  },
  methods: {
    async getStudentWork() {
      await this.axios
        .get(baseUrl + "/api/class/activity/studentworkdata", {
          params: {
            user_id: sessionUserId,
            class_id: this.$route.params.class_id,
            activity_id: this.$route.params.activity_id,
          },
        })
        .then((response) => {
          this.studentWork = response.data.activity_detail;
          this.studentScore = response.data.scoring;
          // console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.studentWork = [];
        });
    },
    submitWork() {
      // var swFileValue = [];
      // normal upload
      let normalFormData = new FormData();

      if (!this.isMobile) {
        let v = 0;
        $("input[name='file']").each(function () {
          // swFileValue.push($(this).val());
          var test = v++;
          normalFormData.append(
            "submitStudentData[" + test + "]",
            $(this).val()
          );
        });
      }

      if (this.isMobile) {
        for (var i = 0; i < this.normalFiles.length; i++) {
          let normalFile = this.normalFiles[i];
          normalFormData.append("file[" + i + "]", normalFile);
        }
      }

      // normalFormData.append("submitStudentData", swFileValue);
      normalFormData.append("user_id", sessionUserId);
      normalFormData.append("classId", this.$route.params.class_id);
      normalFormData.append("activityId", this.$route.params.activity_id);
      normalFormData.append("isMobile", this.isMobile);
      // console.log(swFileValue);
      this.axios
        .post(
          baseUrl + "/api/class/activity/submitStudentWork",
          normalFormData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then((response) => {
          // console.log(swFileValue);
          this.$refs.swpond.removeFiles();
          this.showRemoveFile = false;
          this.getStudentWork();
          $("#normalFiles").val("");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    handleFilePondInit: function () {
      // example of instance method call on pond reference
      this.$refs.swpond.getFiles();
    },
    unsubmitWork() {
      this.axios
        .post(baseUrl + "/api/class/activity/unsubmitStudentWork", {
          classId: this.$route.params.class_id,
          activityId: this.$route.params.activity_id,
          userId: sessionUserId,
        })
        .then((response) => {
          this.showRemoveFile = true;
          this.getStudentWork();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteWork(activity_detail_id) {
      this.axios({
        method: "DELETE",
        url: baseUrl + "/api/class/activity/deleteStudentWork",
        data: {
          classId: this.$route.params.class_id,
          activityId: this.$route.params.activity_id,
          activity_detail_id: activity_detail_id,
        },
      })
        .then((response) => {
          this.getStudentWork();
        })
        .catch(() => {
          error();
        });
    },
    downloadFile(sw_id) {
      window.open(
        baseUrl +
          "/api/class/activity/downloadStudentWork/" +
          this.$route.params.class_id +
          "/" +
          sw_id,
        "_blank"
      );
    },
    asset(path) {
      return imgUrl + path;
    },
    handleFileUploads() {
      this.normalFiles = this.$refs.normalFilesRefs.files;
    },
  },
  components: {
    activityInstruction,
    FilePond,
  },
};
</script>
<style scoped>
.file-attachment {
  border: 1px solid #c4c0c0;
  margin: 5px;
}

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
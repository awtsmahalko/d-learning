<template>
  <div class="container mt-3">
    <div class="col-md-12">
      <div class="row">
        <!-- start loop -->
        <div class="card my-2">
          <div style="width: 100%">
            <div class="col-md-12 pt-2" style="overflow-x: auto">
              <div class="d-flex">
                <div class="flex-shrink-0" style="padding: 11px">
                  <img
                    class="avatar rounded-circle me-3"
                    :src="
                      assetPP(
                        activities.user != null ? activities.user.avatar : ''
                      )
                    "
                    :alt="activities.user != null ? activities.user.avatar : ''"
                    style="width: 40px; height: 40px"
                  />
                </div>
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
                    style="display: flex; flex-direction: column; width: 100%"
                  >
                    <h3 class="card-title mb-0">
                      <b class="comment" id="post-user">{{
                        activities.title
                      }}</b>
                    </h3>
                    <p class="text-muted mt-0 normalText">
                      Posted on
                      {{ formatDate(activities.created_at) }}
                    </p>
                    <p
                      class="instructionDescription"
                      v-html="activities.instruction"
                    ></p>

                    <!-- attachments -->
                    <div class="col-md-12" style="border-top: 1px solid #ddd">
                      <div class="row">
                        <!-- loop attachments -->
                        <div
                          class="col-md-6"
                          v-for="(
                            material, key
                          ) in activities.activity_material"
                          :key="key"
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
                                  padding: 0px;
                                "
                              >
                                <div
                                  class="card-icon p-0"
                                  style="border-right: 1px solid #c4c0c0"
                                >
                                  <img
                                    :src="asset(material.thumbnail)"
                                    :alt="material.thumbnail"
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
                                    width: 69%;
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
                                    @click="downloadMaterial(material.id)"
                                  >
                                    <b id="post-user">{{
                                      material.filename
                                    }}</b>
                                  </h4>
                                  <small class="card-category mt-0 text-muted">
                                    {{ material.filetype }}
                                  </small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /loop attachments -->
                      </div>
                    </div>
                    <!-- /attachments -->

                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-6 text-left">
                          <p class="additionalLabel">
                            <b>
                              {{
                                activities.category == "A"
                                  ? "ACTIVITY"
                                  : activities.category == "E"
                                  ? "EXAM"
                                  : "QUIZ"
                              }}
                              : {{ parseInt(activities.points) }} points</b
                            >
                          </p>
                        </div>

                        <div class="col-md-6 text-right">
                          <p class="additionalLabel">
                            <b>Due: {{ formatDate(activities.duedate) }}</b>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-if="session.category === 'T'">
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
                      <a class="dropdown-item" @click="editClassworkModal"
                        >Edit</a
                      >
                      <a class="dropdown-item" @click="deleteClasswork"
                        >Delete</a
                      >
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

    <!-- modal -->
    <div
      class="modal fade"
      id="editClassworkModal"
      role="dialog"
      aria-labelledby="editClassworkModal"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form id="modal_new_activity" @submit.prevent="updateClasswork">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="editClassworkModal">Details</h5>
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
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <form @submit.prevent="submitPost">
                            <div class="row">
                              <div class="col-md-12">
                                <div
                                  class="form-group bmd-form-group"
                                  v-show="is_Exam_title ? false : true"
                                >
                                  <label for="text_title">Title</label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="activityDetail.text_title"
                                    name="text_title"
                                    id="text_title"
                                  />
                                </div>
                                <div class="form-group" v-show="is_Exam_title">
                                  <label for="title">Title</label>
                                  <select
                                    class="form-control"
                                    name="title"
                                    v-model="activityDetail.title"
                                    id="title"
                                  >
                                    <option value="">-- select term --</option>
                                    <option value="Prelim">Prelim</option>
                                    <option value="Midterm">Midterm</option>
                                    <option value="Enterm">Enterm</option>
                                  </select>
                                </div>
                                <div class="form-group bmd-form-group">
                                  <textarea
                                    class="form-control summernote"
                                    id="snactivityDetail"
                                    required
                                  ></textarea>
                                </div>
                              </div>
                              <div
                                class="col-md-12"
                                style="border-top: 2px solid #ddd"
                              >
                                <div class="row">
                                  <div class="col-md-12 mt-1">
                                    <file-pond
                                      name="file"
                                      ref="napond"
                                      label-idle="Drop attachment here..."
                                      v-bind:allow-multiple="true"
                                      :files="activityDetailFiles"
                                      :server="server"
                                      v-on:init="handleFilePondInit"
                                    />
                                  </div>

                                  <!-- attachments -->
                                  <div
                                    class="col-md-12"
                                    style="border-top: 1px solid #ddd"
                                  >
                                    <div class="row">
                                      <!-- loop attachments -->
                                      <div
                                        class="col-md-6"
                                        v-for="(
                                          material, key
                                        ) in activities.activity_material"
                                        :key="key"
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
                                                style="
                                                  border-right: 1px solid
                                                    #c4c0c0;
                                                "
                                              >
                                                <img
                                                  :src="
                                                    asset(material.thumbnail)
                                                  "
                                                  :alt="material.thumbnail"
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
                                                  width: 56%;
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
                                                  @click="
                                                    downloadMaterial(
                                                      material.id
                                                    )
                                                  "
                                                >
                                                  <b id="post-user">{{
                                                    material.filename
                                                  }}</b>
                                                </h4>
                                                <small
                                                  class="
                                                    card-category
                                                    mt-0
                                                    text-muted
                                                  "
                                                >
                                                  {{ material.filetype }}
                                                </small>
                                              </div>
                                              <div
                                                class="ms-auto"
                                                v-show="is_teacher"
                                              >
                                                <a
                                                  class="attachment-remove"
                                                  @click="
                                                    deleteClassworkMaterial(
                                                      material.id
                                                    )
                                                  "
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
                                      </div>
                                      <!-- /loop attachments -->
                                    </div>
                                  </div>
                                  <!-- /attachments -->
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="col-md-4 py-4 mt-2"
                  style="border-left: 1px solid #ddd"
                >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cw_category">Category</label>
                      <select
                        class="form-control"
                        v-model="activityDetail.cw_category"
                        @change="displayTitle"
                      >
                        <option value="A">Activity</option>
                        <option value="E">Exam</option>
                        <option value="Q">Quiz</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="points">Points</label>
                      <input
                        type="number"
                        v-model="activityDetail.points"
                        class="form-control"
                        id="points"
                      />
                    </div>
                    <div class="form-group">
                      <label for="dueDate">Due Date</label>
                      <input
                        type="datetime-local"
                        v-model="activityDetail.duedate"
                        class="form-control"
                        id="dueDate"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                Save changes
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
// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Create component
const FilePond = vueFilePond();

const options = {
  placeholder: "Instructions (optional)",
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "underline", "clear"]],
    ["para", ["ul", "ol", "paragraph"]],
  ],
  disableDragAndDrop: true,
  spellCheck: true,
};

export default {
  props: ["activityid"],
  data() {
    return {
      is_teacher: false,
      is_Exam_title: false,
      activityDetailFiles: [],
      activities: [],
      activity: {
        user_id: sessionUserId,
        id: "",
      },
      activityDetail: {
        id: "",
        user_id: sessionUserId,
        classworkFiles: [],
        class_id: "",
        title: "",
        text_title: "",
        cw_category: "",
        points: "",
        duedate: "",
        instructions: "",
      },
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("classId", this.activityDetail.class_id);
          // console.log(this.$route.params.activity_id);
          this.axios({
            method: "POST",
            url: baseUrl + "/api/class/activity/uploadClassworkAttachment",
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
            url: baseUrl + "/api/class/activity/revertClassWorkMaterial",
            data: {
              file: uniqueFileId,
              classId: this.activityDetail.class_id,
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
    this.activity.id = this.activityid;
    this.activityDetail.id = this.activityid;
    this.activityDetail.class_id = this.$route.params.id;
  },
  mounted() {
    this.is_Exam_title = false;
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.getActivity();

    const vm = this;

    options.callbacks = {
      onChange(contents) {
        vm.activityDetail.instructions = contents;
      },
    };

    $("textarea#snactivityDetail").summernote(options);
    $("textarea#snactivityDetail").summernote("code", "<br>");

    $("#dueDate").val(
      new Date(this.activityDetail.duedate).toLocaleDateString()
    );
  },
  methods: {
    async getActivity() {
      await this.axios
        .get(baseUrl + "/api/class/activity/detail", {
          params: {
            user_id: sessionUserId,
            activityId: this.activityid,
          },
        })
        .then((response) => {
          this.activities = response.data;
          this.activityDetail.class_id = response.data.class_id;
          // console.log(response.data);

          this.activityDetail.instructions = response.data.instruction;
          $("#snactivityDetail").summernote("reset");
          $("#snactivityDetail").summernote("code", response.data.instruction);

          this.activityDetail.points = response.data.points;
          this.activityDetail.duedate = new Date(
            response.data.duedate
          ).toLocaleDateString();

          this.activityDetail.cw_category = response.data.category;

          if (response.data.category == "E") {
            this.activityDetail.title = response.data.title;
          } else {
            this.activityDetail.text_title = response.data.title;
          }

          this.displayTitle();

          // console.log(this.activityDetail);
        })
        .catch((error) => {
          console.log(error);
          this.activities = [];
        });
    },
    deleteClassworkMaterial(material_id) {
      this.axios({
        method: "DELETE",
        url: baseUrl + "/api/class/activity/deleteClassWorkMaterial",
        data: {
          activity: this.activities,
          material_id: material_id,
        },
      })
        .then((response) => {
          this.getActivity();
        })
        .catch(() => {
          error();
        });
    },
    editClassworkModal() {
      this.getActivity();
      $("#editClassworkModal").modal("show");
    },
    updateClasswork() {
      var cwFileValue = [];
      $("input[name='file']").each(function () {
        cwFileValue.push($(this).val());
      });

      this.activityDetail.classworkFiles = cwFileValue;

      this.axios
        .post(baseUrl + "/api/class/activity/edit", this.activityDetail)
        .then((response) => {
          this.$refs.napond.removeFiles();
          this.getActivity();
          $("#editClassworkModal").modal("hide");
          alertMe(response.data.message);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    displayTitle() {
      if (this.activityDetail.cw_category == "E") {
        this.activityDetail.text_title = "";
        this.is_Exam_title = true;
      } else {
        this.activityDetail.title = "";
        this.is_Exam_title = false;
      }
    },
    downloadMaterial(material_id) {
      window.open(
        baseUrl +
          "/api/class/activity/downloadClassWorkMaterial/" +
          this.activityDetail.class_id +
          "/" +
          material_id,
        "_blank"
      );
    },
    handleFilePondInit: function () {
      // console.log("new activity FilePond has initialized");
      // example of instance method call on pond reference
      this.$refs.napond.getFiles();
      // console.log(this.$refs.napond.getFiles());
    },
    assetPP(path) {
      var thumbs =
        path == null || path == ""
          ? imgUrl + "/profile/default/default_avatar.jpeg"
          : imgUrl + path;
      return thumbs;
    },
    asset(path) {
      return imgUrl + path;
    },
    formatDate(date) {
      return new Date(date).toLocaleString("en-US", { timeZone: "UTC" });
    },
    deleteClasswork() {
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
              .post(
                baseUrl + "/api/class/activity/delete",
                _this.activityDetail
              )
              .then((response) => {
                console.log(_this.activityDetail);
                success_delete();
                window.location.href =
                  "/class/" + _this.activityDetail.class_id;
              })
              .catch((error) => {
                console.log(error);
              });
          });
        },
        allowOutsideClick: false,
      });
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
  font-size: 16px;
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

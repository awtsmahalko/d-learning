<template>
  <div class="container mt-3">
    <div class="col-md-12" v-show="is_teacher">
      <button
        type="submit"
        class="btn btn-md btn-primary"
        v-on:click="popClassworkModal"
      >
        <span class="material-icons"> add </span> Create
      </button>
    </div>
    <div class="col-md-12">
      <!-- start loop -->
      <div class="card my-2" v-for="(activity, key) in activities" :key="key">
        <div style="width: 100%padding: 11px;">
          <div class="col-md-12">
            <div class="d-flex">
              <div class="flex-shrink-0" style="padding: 11px">
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
                <div v-if="session.category === 'T'">
                  <router-link
                    :to="{
                      name: 'activityViewTeacher',
                      params: {
                        class_id: activity.class_id,
                        activity_id: activity.id,
                      },
                    }"
                  >
                    <div
                      class="mx-2"
                      style="display: flex; flex-direction: column"
                    >
                      <h6 class="card-title mb-0">
                        <b class="comment" id="post-user"
                          >{{ activity.user.fname }} Posted a new
                          {{
                            activity.category == "A"
                              ? "ACTIVITY"
                              : activity.category == "E"
                              ? "EXAM"
                              : "QUIZ"
                          }}: {{ activity.title }}</b
                        >
                      </h6>
                      <small class="text-muted mt-0">
                        Posted
                        {{ new Date(activity.created_at).toLocaleString() }}
                      </small>
                    </div>
                  </router-link>
                </div>
                <div v-else>
                  <router-link
                    :to="{
                      name: 'activityViewStudent',
                      params: {
                        class_id: activity.class_id,
                        activity_id: activity.id,
                      },
                    }"
                  >
                    <div
                      class="mx-2"
                      style="
                        display: flex;
                        flex-direction: column;
                        padding-top: 6px;
                      "
                    >
                      <h6 class="card-title mb-0">
                        <b class="comment" id="post-user"
                          >{{ activity.user.fname }} Posted a new
                          {{
                            activity.category == "A"
                              ? "ACTIVITY"
                              : activity.category == "E"
                              ? "EXAM"
                              : "QUIZ"
                          }}: {{ activity.title }}</b
                        >
                      </h6>
                      <small class="text-muted mt-0">
                        Posted
                        {{ new Date(activity.created_at).toLocaleString() }}
                      </small>
                    </div>
                  </router-link>
                </div>

                <div v-show="is_teacher == false ? true : false">
                  <div
                    v-show="activity.activity_details_count > 0 ? true : false"
                  >
                    <span style="color: green; font-weight: 500"
                      >SUBMITTED</span
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

    <!-- modal -->
    <div
      class="modal fade"
      id="createClassworkModal"
      role="dialog"
      aria-labelledby="createClassworkModal"
      aria-hidden="true"
    >
      <div
        class="modal-dialog"
        role="document"
        style="max-width: 80% !important"
      >
        <div class="modal-content">
          <form id="modal_new_activity" @submit.prevent="createClasswork">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="createClassworkModal">
                New Activity
              </h5>
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
                                  <label class="bmd-label-floating"
                                    >Title</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="newActivity.text_title"
                                    name="text_title"
                                    id="text_title"
                                  />
                                </div>
                                <div class="form-group" v-show="is_Exam_title">
                                  <label for="title">Title</label>
                                  <select
                                    class="form-control"
                                    name="title"
                                    v-model="newActivity.title"
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
                                    id="snnewactivity"
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
                                      :files="newActivityFiles"
                                      :server="server"
                                      v-on:init="handleFilePondInit"
                                    />
                                  </div>
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
                        v-model="newActivity.cw_category"
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
                        v-model="newActivity.points"
                        class="form-control"
                        id="points"
                      />
                    </div>
                    <div class="form-group">
                      <label for="dueDate">Due Date</label>
                      <input
                        type="date"
                        v-model="newActivity.duedate"
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
  name: "class-work",
  data() {
    return {
      is_teacher: false,
      is_Exam_title: false,
      classData: {},
      newActivityFiles: [],
      activities: [],
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
      newActivity: {
        user_id: sessionUserId,
        classworkFiles: [],
        class_id: "",
        title: "",
        text_title: "",
        cw_category: "",
        points: "",
        duedate: "",
        instructions: "<br>",
      },
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("classId", this.newActivity.class_id);
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
              classId: this.newActivity.class_id,
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
    this.newActivity.class_id = this.$route.params.id;

    this.axios
      .get(baseUrl + `/api/class/${this.$route.params.id}`)
      .then((res) => {
        this.classData = res.data;
      });
  },
  mounted() {
    this.is_Exam_title = false;
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.getActivity();
    const vm = this;

    options.callbacks = {
      onChange(contents) {
        vm.newActivity.instructions = contents;
      },
    };

    $("textarea#snnewactivity").summernote(options);
    $("textarea#snnewactivity").summernote("code", "<br>");
  },
  methods: {
    async getActivity() {
      await this.axios
        .get(baseUrl + "/api/class/activity/view", {
          params: {
            user_id: sessionUserId,
            class_id: this.$route.params.id,
          },
        })
        .then((response) => {
          this.activities = response.data;
          // this.postsAttachments = response.data.post_attachments;
          // console.log(this.activities);
        })
        .catch((error) => {
          console.log(error);
          this.activities = [];
        });
    },
    popClassworkModal() {
      $("#createClassworkModal").modal("show");
    },
    createClasswork() {
      var cwFileValue = [];
      $("input[name='file']").each(function () {
        cwFileValue.push($(this).val());
      });

      this.newActivity.classworkFiles = cwFileValue;

      this.axios
        .post(baseUrl + "/api/class/activity/add", this.newActivity)
        .then((response) => {
          if(response.data.counter == 1){
            this.getActivity();
            $("#createClassworkModal").modal("hide");
            $("#modal_new_activity").trigger("reset");
            alertMe(response.data.message);
          }else if(response.data.counter == 2){
            entry_already_exists();
          }else{
            alertMe(response.data.message);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    displayTitle() {
      if (this.newActivity.cw_category == "E") {
        this.newActivity.text_title = "";
        this.is_Exam_title = true;
      } else {
        this.newActivity.title = "";
        this.is_Exam_title = false;
      }
    },
    handleFilePondInit: function () {
      // console.log("new activity FilePond has initialized");
      // example of instance method call on pond reference
      this.$refs.napond.getFiles();
      // console.log(this.$refs.napond.getFiles());
    },
  },
  components: {
    FilePond,
  },
};
</script>
<style scoped>
.comment {
  font-size: 14px;
  font-weight: 800;
  margin-bottom: 2px;
  /* white-space: break-spaces; */
}

.dropdown-toggle::after {
  content: none !important;
}
</style>

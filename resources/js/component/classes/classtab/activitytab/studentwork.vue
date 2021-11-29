<template>
  <div class="container mt-3">
    <div class="col-md-12">
      <div class="row">
        <!-- start loop -->
        <div
          class="card my-2"
          v-for="(studentWork, key) in studentWorks"
          :key="key"
        >
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
                    width: 100%;
                    padding: 11px;
                  "
                >
                  <div
                    class="mx-2"
                    style="display: flex; flex-direction: column; width: 100%"
                  >
                    <h6 class="card-title mb-0">
                      <b class="comment" id="post-user">{{
                        studentWork.user.fname
                      }}</b>
                    </h6>
                    <small class="text-muted mt-0">
                      <b>FILES :</b> {{ studentWork.total }} | <b>SCORE:</b>
                      {{ studentWork.score }}
                    </small>

                    <div class="col-md-12" style="border-top: 1px solid #ddd">
                      <div class="row">
                        <!-- attachments -->
                        <div
                          class="col-md-12"
                          style="border-top: 1px solid #ddd"
                        >
                          <div class="row">
                            <!-- loop attachments -->
                            <div
                              class="col-md-6"
                              v-for="(studentFile, key) in studentWork.details"
                              :key="key"
                            >
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
                                        @click="downloadFile(studentFile.id)"
                                      >
                                        <b id="post-user">{{
                                          studentFile.filename
                                        }}</b>
                                      </h4>
                                      <small
                                        class="card-category mt-0 text-muted"
                                      >
                                        {{ studentFile.filetype }}
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
                      </div>
                    </div>
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
                      <a
                        class="dropdown-item"
                        @click="openScoringModal(studentWork.user.id)"
                        >Add Score</a
                      >
                      <!-- <a class="dropdown-item" href="#">Delete</a> -->
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
      id="scoringModal"
      role="dialog"
      aria-labelledby="scoringModal"
      aria-hidden="true"
    >
      <div
        class="modal-dialog"
        role="document"
        style="max-width: 40% !important"
      >
        <div class="modal-content">
          <form id="modal_addScore" @submit.prevent="addScore">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="createClassworkModal">Scoring</h5>
              <input
                type="hidden"
                v-model="activity.student_id"
                id="student_id"
              />
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
                      <label for="points">Your score</label>
                      <input
                        type="number"
                        v-model="activity.student_score"
                        class="form-control"
                        id="points"
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
export default {
  name: "student-work",
  props: ["activityid"],
  data() {
    return {
      is_teacher: false,
      classData: {},
      newActivityFiles: [],
      studentWorks: [],
      classworkHeader: [],
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
      activity: {
        user_id: sessionUserId,
        id: "",
        student_id: "",
        student_score: "",
        class_id: "",
      },
    };
  },
  created() {
    this.activity.id = this.activityid;
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.getActivity();
    this.getHeaderActivity();
  },
  methods: {
    async getActivity() {
      await this.axios
        .get(baseUrl + "/api/class/activity/studentswork", {
          params: {
            user_id: sessionUserId,
            activityId: this.activityid,
          },
        })
        .then((response) => {
          this.studentWorks = response.data;
          // this.postsAttachments = response.data.post_attachments;
          // console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.studentWorks = [];
        });
    },
    async getHeaderActivity() {
      await this.axios
        .get(baseUrl + "/api/class/activity/detail", {
          params: {
            user_id: sessionUserId,
            activityId: this.activityid,
          },
        })
        .then((response) => {
          this.classworkHeader = response.data;
          this.activity.class_id = response.data.class_id;
        })
        .catch((error) => {
          console.log(error);
          this.classworkHeader = [];
        });
    },
    openScoringModal(id) {
      this.activity.student_id = id;

      this.axios
        .get(baseUrl + "/api/class/activity/getScore", {
          params: {
            student_id: id,
            activityId: this.activityid,
          },
        })
        .then((response) => {
          this.activity.student_score = response.data;
        })
        .catch((error) => {
          console.log(error);
        });

      $("#scoringModal").modal("show");
    },
    addScore() {
      this.axios
        .post(baseUrl + "/api/class/activity/addScore", this.activity)
        .then((response) => {
          this.getActivity();
          this.getHeaderActivity();
          $("#scoringModal").modal("hide");
          $("#modal_addScore").trigger("reset");
          alertMe(response.data.message);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    downloadFile(sw_id) {
      window.open(
        baseUrl +
          "/api/class/activity/downloadStudentWork/" +
          this.activity.class_id +
          "/" +
          sw_id,
        "_blank"
      );
    },
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

<template>
  <div class="content">
    <div class="container-fluid">
      <card-title :classesId="$route.params.id"></card-title>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Meetings</h4>
              <p class="card-category">Here you can manage your meetings</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right" v-show="is_teacher">
                  <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    @click.prevent="showModal"
                  >
                    ADD MEETING
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                      </tr>
                    </thead>
                    <tbody v-if="meetings.length > 0">
                      <tr v-for="(meet, key) in meetings" :key="key">
                        <td>{{ meet.class }}</td>
                        <td>{{ meet.title }}</td>
                        <td>{{ meet.description }}</td>
                        <td>
                          {{ new Date(meet.scheduled_at).toLocaleString() }}
                        </td>
                        <td>{{ meet.status == "F" ? "Ended" : "Active" }}</td>
                        <td class="text-right">
                          <div
                            v-show="is_teacher"
                            class="btn-group"
                            role="group"
                          >
                            <button
                              v-show="meet.status == 'F' ? true : false"
                              class="btn btn-sm btn-warning"
                              @click="fetchAttendee(meet.id)"
                            >
                              <i class="material-icons">people</i> Attendees
                            </button>
                            <button
                              v-show="meet.status == 'P' ? true : false"
                              class="btn btn-sm btn-info"
                              @click="finishMeeting(meet.id)"
                            >
                              <i class="material-icons">check_circle</i> FINISH
                              MEETING
                            </button>
                          </div>
                          <div
                            v-show="meet.status != 'F' ? true : false"
                            class="btn-group"
                            role="group"
                          >
                            <router-link
                              class="btn btn-sm btn-primary"
                              :to="{
                                name: 'meeting',
                                params: {
                                  id: meet.id,
                                  number: meet.number,
                                  password: meet.password,
                                  class_id: meet.class_id,
                                },
                              }"
                              ><span class="material-icons">videocam</span>
                              {{ is_teacher ? "Start" : "Join" }}</router-link
                            >
                            <button
                              v-show="is_teacher"
                              class="btn btn-sm btn-success"
                              @click="editMeeting(meet.id)"
                            >
                              <i class="material-icons">edit_note</i> Edit
                            </button>
                            <button
                              v-show="is_teacher"
                              class="btn btn-sm btn-danger"
                              @click="deleteMeeting(meet.id)"
                            >
                              <i class="material-icons">delete_forever</i>
                              Delete
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="4" align="center">No Meeting Found</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal containing dynamic form for adding/updating user details. -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
            <h5
              v-show="is_form_create"
              class="modal-title"
              id="exampleModalLabel"
            >
              Add new meeting
            </h5>
            <h5
              v-show="!is_form_create"
              class="modal-title"
              id="exampleModalLabel"
            >
              Update meeting
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
          <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
          <form @submit.prevent="createMeeting">
            <div class="modal-body">
              <div class="form-group bmd-form-group">
                <label>Title</label>
                <input
                  v-model="meeting.title"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group bmd-form-group">
                <label>Description</label>
                <input
                  v-model="meeting.description"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group bmd-form-group">
                <label>Date</label>
                <input
                  v-model="meeting.scheduled_at"
                  type="datetime-local"
                  id="datetimepicker"
                  class="form-control"
                  required
                />
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-sm btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="submit"
                id="btn-submit"
                class="btn btn-sm btn-primary"
              >
                Save changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
        <!-- Modal containing dynamic form for adding/updating user details. -->
    <div
      class="modal fade"
      id="attendeeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="attendeeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
            <h5
              class="modal-title"
              id="attendeeModalLabel"
            >
              <i class="material-icons">people</i>  Meeting Participants
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
          <div class="modal-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <tr>
                      <th>#</th>
                      <th>Attendee</th>
                      <th>Joined Time</th>
                    </tr>
                  </thead>
                  <tbody v-if="attendees.length > 0">
                    <tr v-for="(attendee, key) in attendees" :key="key">
                      <td>{{ attendee.id }}</td>
                      <td>{{ attendee.fname + ' ' + attendee.mname + ' ' + attendee.lname }} {{ attendee.category == 'T'?'(Host)':''}}</td>
                      <td>{{ new Date(attendee.created_at).toLocaleString() }}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="4" align="center">No Attendees Found</td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CardTitle from "./../classes/cardTitle.vue";
export default {
  name: "video-view",
  data() {
    return {
      is_teacher: false,
      is_form_create: true,
      meeting: {
        id: 0,
        user_id: sessionUserId,
        class_id: "",
        title: "",
        description: "",
        scheduled_at: "",
      },
      meetings: [],
      attendees : [],
    };
  },
  methods: {
    createMeeting() {
      $("#btn-submit").prop("disabled", true);
      axios
        .post(baseUrl + "/api/video/create", this.meeting)
        .then((response) => {
          $("#btn-submit").prop("disabled", false);
          this.fetchMeetings();
          $("#exampleModal").modal("hide");
          this.is_form_create ? success_add() : success_update();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchMeetings() {
      axios
        .get(baseUrl + "/api/video", {
          params: {
            user_id: sessionUserId,
            category: sessionCategory,
            class_id: this.meeting.class_id,
          },
        })
        .then((response) => {
          this.meetings = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showModal() {
      this.resetForm();
      this.is_form_create = true;
      $("#exampleModal").modal("show");
    },
    editMeeting(id) {
      this.is_form_create = false;
      axios
        .get(baseUrl + `/api/video/${id}`)
        .then((response) => {
          this.meeting = response.data;
          // this.meeting.scheduled_at = new Date(response.data.scheduled_at).toISOString();
          // this.meeting.scheduled_at = new Date(response.data.scheduled_at).toLocaleString().slice(0, 19);
          $("#exampleModal").modal("show");
        })
        .catch((error) => {});
    },
    deleteMeeting(id) {
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
            axios
              .delete(baseUrl + `/api/video/${id}`)
              .then((response) => {
                _this.fetchMeetings();
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
    resetForm() {
      this.meeting.id = 0;
      this.meeting.title = "";
      this.meeting.description = "";
      this.meeting.scheduled_at = "";
    },
    finishMeeting(id) {
      var _this = this;
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, finish it!",
        showLoaderOnConfirm: true,
        preConfirm: function () {
          return new Promise(function (resolve) {
            axios
              .post(baseUrl + `/api/video/${id}/edit`)
              .then((response) => {
                _this.fetchMeetings();
                success_update();
              })
              .catch((error) => {
                console.log(error);
              });
          });
        },
        allowOutsideClick: false,
      });
    },
    fetchAttendee(id) {
      $("#attendeeModal").modal("show");
      this.attendees = [];
        axios
        .get(baseUrl + `/api/video/attendee/${id}`)
        .then((response) => {
          console.log(response);
          this.attendees = response.data;
        })
        .catch((error) => {});
    },
  },
  created() {
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.meeting.class_id = this.$route.params.id;
    this.fetchMeetings();
  },
  mounted() {},
  components: {
    CardTitle,
  },
};
</script>
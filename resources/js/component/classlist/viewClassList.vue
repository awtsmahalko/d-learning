<template>
  <div class="content pt-0">
    <div class="container-fluid pt-0">
      <card-title
        v-show="is_teacher"
        :classesId="studlist.class_id"
      ></card-title>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div v-show="is_teacher" class="card-header card-header-primary">
              <h4 class="card-title">Class list</h4>
              <p class="card-category">
                Here you can manage your list of students
              </p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <button
                    v-show="is_teacher"
                    class="btn btn-sm btn-primary"
                    v-on:click="showAddModal"
                  >
                    Add Student
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Date Joined</th>
                        <th v-show="is_teacher" class="text-right">Actions</th>
                      </tr>
                    </thead>
                    <tbody v-if="studentsList.length > 0">
                      <tr v-for="(list, key) in studentsList" :key="key">
                        <td></td>
                        <td>
                          {{
                            list.user.fname +
                            " " +
                            list.user.mname +
                            " " +
                            list.user.lname
                          }}
                        </td>
                        <td>
                          {{ new Date(list.created_at).toLocaleString() }}
                        </td>
                        <td v-show="is_teacher">
                          <button
                            v-show="is_teacher"
                            class="btn btn-sm btn-danger"
                            @click="removeStudent(list.id)"
                          >
                            <span class="material-icons">remove_circle</span>
                            Remove
                          </button>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="4" align="center">No Class List Found</td>
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

    <!-- modal -->
    <div
      class="modal fade"
      id="addModal"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form @submit.prevent="addStudent">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 class="modal-title" id="exampleModalLabel">
                Add Student to List
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
              <div class="form-group bmd-form-group">
                <label>Student</label>
                <select
                  class="form-control select2"
                  style="width: 100%"
                  id="student_id"
                  required
                >
                  <option value="">-- Select student --</option>
                  <option
                    v-for="(values, key) in students"
                    :key="key"
                    :value="values.id"
                  >
                    {{ values.fname + " " + values.mname + " " + values.lname }}
                  </option>
                </select>
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
import cardTitle from "../classes/cardTitle.vue";

export default {
  components: { cardTitle },
  name: "view-class-list",
  data() {
    return {
      is_teacher: false,
      studentsList: [],
      students: [],
      studlist: {
        class_id: "",
        student_id: "",
      },
    };
  },
  created() {
    this.studlist.class_id = this.$route.params.id;
    this.fetchStudentsList();
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;

    $(".select2").select2();
    this.fetchStudentsList();
    this.fetchStudents();

    $("#student_id").change(
      function () {
        this.studlist.student_id = $("#student_id").val();
      }.bind(this)
    );
  },
  methods: {
    showAddModal() {
      this.resetForm();
      $("#addModal").modal("show");
    },
    fetchStudents() {
      axios
        .get(baseUrl + "/api/studentsList/students", {
          params: {
            user_id: sessionUserId,
          },
        })
        .then((data) => {
          this.students = data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchStudentsList() {
      axios
        .get(baseUrl + "/api/studentsList", {
          params: {
            class_id: this.$route.params.id,
          },
        })
        .then((data) => {
          this.studentsList = data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addStudent() {
      axios
        .post(baseUrl + "/api/studentsList", {
          student_list: this.studlist,
        })
        .then((data) => {
          $("#addModal").modal("hide");
          data.data == 1 ? success_add() : entry_already_exists();
          this.fetchStudentsList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removeStudent(id) {
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
              .delete(baseUrl + `/api/deleteStudentsList/${id}`)
              .then((response) => {
                _this.fetchStudentsList();
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
      $("#student_id").val("");

      $(".select2").select2().trigger("change");
    },
  },
};
</script>
<style scoped>
.card.card-background .full-background {
  background-position: 50%;
  background-size: cover;
  margin-bottom: 30px;
  width: 100%;
  height: 100%;
  position: absolute;
  border-radius: 0.75rem;
}

.card .card-background {
  align-items: center;
}

.card-background {
  height: 200px;
  margin-top: 0px;
  margin-bottom: 0px;
}

.btn-width {
  width: 100%;
}

.filepond--wrapper {
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
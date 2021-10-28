<template>
  <div class="container mt-3">
    <div class="col-md-12">
      <button
        type="submit"
        class="btn btn-md btn-primary"
        v-on:click="popClassworkModal"
      >
        <span class="material-icons"> add </span> Create
      </button>
    </div>
    <div class="col-md-12">
      <div class="card my-2">
        <div style="width: 100%padding: 11px;">
          <!-- start loop -->
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
                <div class="mx-2" style="display: flex; flex-direction: column">
                  <h6 class="card-title mb-0">
                    <b class="comment" id="post-user"
                      >Teacher Rino Posted a new classwork: Assignment #1</b
                    >
                  </h6>
                  <small class="text-muted mt-0"> Posted Aug 15, 2018 </small>
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
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Delete</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end loop -->
        </div>
      </div>
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
          <form @submit.prevent="createClasswork">
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
                                <div class="form-group bmd-form-group">
                                  <textarea
                                    class="form-control"
                                    placeholder="Title"
                                    rows="1"
                                    spellcheck="false"
                                  ></textarea>
                                </div>
                                <div class="form-group bmd-form-group">
                                  <!-- <label>Share to your class</label> -->
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
                <div class="col-md-4 py-3" style="border-left: 1px solid #ddd">
                  <div class="col-md-12">
                    <div class="form-group bmd-form-group">
                      <input
                        type="text"
                        class="form-control"
                        placeholder="points"
                      />
                    </div>
                    <div class="form-group bmd-form-group">
                      <input
                        type="text"
                        class="form-control"
                        placeholder="due date"
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
    // ["font", ["bold", "underline", "clear"]],
    // ["color", ["color"]],
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
      classData: {},
      newActivityFiles: [],
      newActivity: {
        user_id: sessionUserId,
        class_id: "",
        title: "",
        points: "",
        duedate: "",
        instructions: "<br>",
      },
      server: {
        process: (fieldName, file, metadata, load, error) => {
          // const formData = new FormData();
          // formData.append("file", file, file.name);
          // formData.append("classId", this.newActivity.class_id);
          // this.axios({
          //   method: "POST",
          //   url: baseUrl + "/api/uploadPostAttachment",
          //   data: formData,
          //   headers: {
          //     "Content-Type": "multipart/form-data",
          //   },
          // })
          //   .then((response) => {
          //     load(response.data);
          //   })
          //   .catch(() => {
          //     error();
          //   });
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
    this.newActivity.class_id = this.$route.params.id;

    this.axios
      .get(baseUrl + `/api/class/${this.$route.params.id}`)
      .then((res) => {
        this.classData = res.data;
      });
  },
  mounted() {
    const vm = this;

    // options.callbacks = {
    //   onChange(contents) {
    //     vm.newActivity.instructions = contents;
    //   },
    // };

    $("textarea#snnewactivity").summernote(options);
    $("textarea#snnewactivity").summernote("code", "<br>");
  },
  methods: {
    popClassworkModal() {
      $("#createClassworkModal").modal("show");
    },
    handleFilePondInit: function () {
      console.log("new activity FilePond has initialized");
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

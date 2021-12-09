<template>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 ml-auto mr-auto">
          <div class="profile" style="text-align: center">
            <!--<div class="avatar">
                            <img src="" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                        </div>-->
            <div class="name">
              <h3 class="title" style="text-transform: uppercase">
                {{ profileDetails.profile_name }}
              </h3>
              <h6>
                {{
                  profileDetails.profile_category == "T" ? "Teacher" : "Student"
                }}
              </h6>
            </div>
          </div>
        </div>
      </div>
      <div class="description text-center">
        <p>Manage your profile information here.</p>
      </div>
      <div class="row">
        <div class="col-md-6 ml-auto mr-auto">
          <div class="profile-tabs">
            <ul
              class="nav nav-pills nav-pills-icons justify-content-center"
              role="tablist"
            >
              <li class="nav-item">
                <a
                  class="nav-link active"
                  href="#profile"
                  role="tab"
                  data-toggle="tab"
                >
                  <i class="material-icons">person</i> My Information
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="#classes"
                  role="tab"
                  data-toggle="tab"
                >
                  <i class="material-icons">palette</i> My classes
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="#security"
                  role="tab"
                  data-toggle="tab"
                >
                  <i class="material-icons">lock</i> Security
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="tab-content tab-space">
        <div class="tab-pane active" id="profile">
          <br />
          <div class="row">
            <div class="col-sm-6 ml-auto mr-auto">
              <div
                class="col-sm-6 ml-auto mr-auto"
                style="width: 200px; height: 200px"
              >
                <div>
                  <img
                    class="avatar rounded-circle me-3"
                    :src="asset(profileDetails.avatar)"
                    :alt="profileDetails.avatar"
                    style="
                      border-radius: 99999rem;
                      overflow: hidden;
                      width: 200px;
                      height: 200px;
                    "
                  />
                  <div
                    class="centered"
                    style="cursor: default"
                    @click="openUploadAvatarModal"
                  >
                    <span class="material-icons" style="font-size: 24px"
                      >edit</span
                    >
                  </div>
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">First Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="profileDetails.fname"
                  required
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Middle Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="profileDetails.mname"
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Last Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="profileDetails.lname"
                  required
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Email</label>
                <input
                  type="email"
                  class="form-control"
                  v-model="profileDetails.email"
                  required
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Username</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="profileDetails.username"
                  required
                />
              </div>

              <button
                class="btn btn-primary"
                id="btn_update_profile"
                @click="updateProfile()"
              >
                Save Changes
              </button>
            </div>
          </div>
        </div>
        <div class="tab-pane text-center" id="classes">
          <br />
          <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <tr>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="classes.length > 0">
                    <tr v-for="(row, key) in classes" :key="key">
                      <td>{{ row.code }}</td>
                      <td>{{ row.name }}</td>
                      <td>
                        <router-link
                          :to="{
                            name: 'classView',
                            params: { id: row.id },
                          }"
                          class="btn btn-primary btn-sm"
                        >
                          View
                        </router-link>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="2">No classes found</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="security">
          <br />
          <div class="row">
            <div class="col-sm-6 ml-auto mr-auto">
              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Old Password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="profileDetails.old_password"
                  required
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">New Password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="profileDetails.new_password"
                  required
                />
              </div>

              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Confirm New Password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="profileDetails.confirm_new_password"
                  required
                />
              </div>

              <button
                class="btn btn-primary"
                id="btn_update_password"
                @click="updatePassword()"
              >
                Update Password
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal -->
    <div
      class="modal fade"
      id="uploadAvatarModal"
      role="dialog"
      aria-labelledby="uploadAvatarModal"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
            <h5 class="modal-title" id="createClassworkModal">Upload Avatar</h5>
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
                  <div
                    class="col-sm-6 ml-auto mr-auto"
                    style="width: 200px; height: 200px"
                  >
                    <file-pond
                      class="filepond"
                      name="file"
                      ref="propond"
                      label-idle="Drag & Drop your picture or <span class='filepond--label-action'>Browse</span>"
                      v-bind:allow-multiple="false"
                      accepted-file-types="image/png, image/jpeg, image/gif"
                      imagePreviewHeight="170"
                      imageCropAspectRatio="1:1"
                      imageResizeTargetWidth="200"
                      imageResizeTargetHeight="200"
                      stylePanelLayout="compact circle"
                      styleLoadIndicatorPosition="center bottom"
                      styleProgressIndicatorPosition="center bottom"
                      styleButtonRemoveItemPosition="left bottom"
                      styleButtonProcessItemPosition="center bottom"
                      v-on:init="handleFilePondInit"
                      :files="profileAvatarFiles"
                      :server="server"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal -->
  </div>
</template>
<script>
// Import Vue FilePond
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageCrop from "filepond-plugin-image-crop";
import FilePondPluginImageResize from "filepond-plugin-image-resize";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import FilePondPluginImageEdit from "filepond-plugin-image-edit";

// Import FilePond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import "filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImageExifOrientation,
  FilePondPluginImagePreview,
  FilePondPluginImageCrop,
  FilePondPluginImageResize,
  FilePondPluginImageTransform,
  FilePondPluginImageEdit
);

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Create component

export default {
  name: "indexProfile",
  data() {
    return {
      profileAvatarFiles: [],
      profileDetails: {
        user_id: window.sessionUserId,
        profile_name: window.sessionFullname,
        profile_category: window.sessionCategory,
        fname: window.sessionFname,
        mname: window.sessionMname,
        lname: window.sessionLname,
        email: window.sessionEmail,
        username: window.sessionUsername,
        avatar: window.sessionAvatar,
        old_password: "",
        new_password: "",
        confirm_new_password: "",
      },
      classes: [],
      server: {
        process: (fieldName, file, metadata, load, error) => {
          const formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("userId", this.profileDetails.user_id);

          this.axios({
            method: "POST",
            url: baseUrl + "/api/updateAvatar",
            data: formData,
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
            .then((response) => {
              // console.log(response.data);
              load(response.data.folder);
              this.profileDetails.avatar = response.data.filename;
            })
            .catch(() => {
              error();
            });
        },
        revert: (uniqueFileId, load, error) => {
          //   this.axios({
          //     method: "DELETE",
          //     url: baseUrl + "/api/class/activity/revertClassWorkMaterial",
          //     data: {
          //       file: uniqueFileId,
          //       classId: this.newActivity.class_id,
          //     },
          //   })
          //     .then((response) => {
          //       load();
          //     })
          //     .catch(() => {
          //       error();
          //     });
          //   // Can call the error method if something is wrong, should exit after
          //   error("oh my goodness");
          //   // Should call the load method when done, no parameters required
          //   load();
        },
      },
    };
  },
  mounted() {
    this.getClasses();
  },
  methods: {
    getClasses() {
      axios
        .get(baseUrl + "/api/class", {
          params: {
            user_id: this.profileDetails.user_id,
            category: this.profileDetails.profile_category,
          },
        })
        .then((response) => {
          this.classes = response.data;
        })
        .catch((error) => {
          failed_query(error);
        });
    },
    updateProfile() {
      $("#btn_update_profile").prop("disabled", true);
      axios
        .post(baseUrl + "/api/updateProfile", {
          id: this.profileDetails.user_id,
          fname: this.profileDetails.fname,
          mname: this.profileDetails.mname,
          lname: this.profileDetails.lname,
          email: this.profileDetails.email,
          username: this.profileDetails.username,
        })
        .then((data) => {
          success_update();
          $("#btn_update_profile").prop("disabled", false);
        })
        .catch((error) => {
          failed_query(error);
        });
    },
    updatePassword() {
      $("#btn_update_password").prop("disabled", true);
      axios
        .post(baseUrl + "/api/updatePassword", {
          id: this.profileDetails.user_id,
          old_password: this.profileDetails.old_password,
          new_password: this.profileDetails.new_password,
          confirm_new_password: this.profileDetails.confirm_new_password,
        })
        .then(({ data }) => {
          if (data == 1) {
            success_update();
          } else {
            failed_query(data);
          }

          $("#btn_update_password").prop("disabled", false);
        })
        .catch((error) => {
          failed_query(error);
        });
    },
    handleFilePondInit: function () {
      // console.log("new activity FilePond has initialized");
      // example of instance method call on pond reference
      this.$refs.propond.getFiles();
      // console.log(this.$refs.napond.getFiles());
    },
    asset(path) {
      var thumbs =
        path == null
          ? imgUrl + "/profile/default/default_avatar.jpeg"
          : imgUrl + path;
      return thumbs;
    },
    openUploadAvatarModal() {
      this.$refs.propond.removeFiles();
      $("#uploadAvatarModal").modal("show");
    },
  },
  components: {
    FilePond,
  },
};
</script>
<style scoped>
.centered {
  color: #d3d3d3;
  background-color: black;
  padding: 5px;
  border-radius: 9999rem;
  position: absolute;
  left: 50%;
  bottom: 10%;
  font-size: 33px;
  opacity: 77%;
}
</style>

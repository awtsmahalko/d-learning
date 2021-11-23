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
                    align-items: center;
                    width: 100%;
                  "
                >
                  <div
                    class="mx-2"
                    style="display: flex; flex-direction: column"
                  >
                    <h6 class="card-title mb-0">
                      <b class="comment" id="post-user">{{
                        studentWork.user.fname
                      }}</b>
                    </h6>
                    <small class="text-muted mt-0">
                      FILES : {{ studentWork.total }}
                    </small>
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
          </div>
        </div>
        <!-- end loop -->
      </div>
    </div>
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
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
      activity: {
        user_id: sessionUserId,
        id: "",
      },
    };
  },
  created() {
    this.activity.id = this.activityid;
  },
  mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
    this.getActivity();
  },
  methods: {
    async getActivity() {
      // alert(
      //   sessionUserId +
      //     " :: " +
      //     this.activity.id +
      //     " :: " +
      //     this.$route.params.id
      // );
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
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.studentWorks = [];
        });
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

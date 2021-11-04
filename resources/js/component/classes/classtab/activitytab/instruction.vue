<template>
  <div class="container mt-3">
    <div class="col-md-12">
      <div class="row">
        <!-- start loop -->
        <div class="card my-2">
          <div style="width: 100%">
            <div class="col-md-12 pt-2">
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
                      Posted •
                      {{ new Date(activities.created_at).toLocaleString() }}
                    </p>
                    <h6
                      class="instructionDescription"
                      v-html="activities.instruction"
                    ></h6>
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
                      <p class="additionalLabel">
                        <b>{{ activities.points }} points</b>
                      </p>
                      <p class="additionalLabel">
                        <b
                          >Due:
                          {{
                            new Date(activities.duedate).toLocaleDateString()
                          }}</b
                        >
                      </p>
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
  props: ["activityid"],
  data() {
    return {
      activities: [],
      activity: {
        user_id: sessionUserId,
        id: "",
      },
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
    };
  },
  created() {
    this.activity.id = this.activityid;
  },
  mounted() {
    this.getActivity();
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
        })
        .catch((error) => {
          console.log(error);
          this.activities = [];
        });
    },
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
</style>

<template>
  <div>
    <!-- start loop -->
    <div class="card" style="margin-bottom: 15px; margin-top: 15px">
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
                align-items: baseline;
                width: 100%;
                margin-top: 3px;
                margin-bottom: 5px;
              "
            >
              <!-- sessionCategory -->
              <div v-if="session.category === 'T'">
                <router-link
                  :to="{
                    name: 'activityViewTeacher',
                    params: { class_id: class_id, activity_id: activity_id },
                  }"
                >
                  <div
                    class="mx-2"
                    style="display: flex; flex-direction: column"
                  >
                    <h6 class="card-title mb-0">
                      <b class="comment" id="post-user"
                        >{{ teacher }} Posted a new
                        {{
                          cw_category == "A"
                            ? "ACTIVITY"
                            : cw_category == "E"
                            ? "EXAM"
                            : "QUIZ"
                        }}: {{ title }}</b
                      >
                    </h6>
                    <small class="text-muted mt-0">
                      Posted
                      {{ new Date(postedDate).toLocaleString() }}
                    </small>
                  </div>
                </router-link>
              </div>
              <div v-else>
                <router-link
                  :to="{
                    name: 'activityViewStudent',
                    params: { class_id: class_id, activity_id: activity_id },
                  }"
                >
                  <div
                    class="mx-2"
                    style="display: flex; flex-direction: column"
                  >
                    <h6 class="card-title mb-0">
                      <b class="comment" id="post-user"
                        >{{ teacher }} Posted a new
                        {{
                          cw_category == "A"
                            ? "ACTIVITY"
                            : cw_category == "E"
                            ? "EXAM"
                            : "QUIZ"
                        }}: {{ title }}</b
                      >
                    </h6>
                    <small class="text-muted mt-0">
                      Posted
                      {{ new Date(postedDate).toLocaleString() }}
                    </small>
                  </div>
                </router-link>
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
</template>
<script>
export default {
  props: [
    "title",
    "classCode",
    "postId",
    "teacher",
    "postedDate",
    "class_id",
    "activity_id",
    "cw_category",
  ],
  data() {
    return {
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
    };
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
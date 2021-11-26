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
              style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%;"
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
                    style="display: flex; flex-direction: column; padding-top: 6px;"
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

              <div v-show="is_teacher == false ? true : false">
                <div
                  v-show="studentSubmitted > 0 ? true : false"
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
    "studentSubmitted",
  ],
  data() {
    return {
      is_teacher: false,
      session: {
        user_id: sessionUserId,
        category: sessionCategory,
      },
    };
  },
   mounted() {
    this.is_teacher = sessionCategory == "T" ? true : false;
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
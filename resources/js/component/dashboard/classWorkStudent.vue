<template>
  <div class="card my-2" style="width: 100%;padding: 5px;">
    <div class="col-md-12">
      <div class="d-flex">
        <div
          style="
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 100%;
          "
        >

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
                <h5 class="card-title mb-0">
                  <b class="comment" id="post-user"
                    >
                    {{
                      activity.category == "A"
                        ? "ACTIVITY"
                        : activity.category == "E"
                        ? "EXAM"
                        : "QUIZ"
                    }}: {{ activity.title }}</b
                  >
                </h5>
                <small class="text-muted mt-0">
                  Posted
                  {{ new Date(activity.created_at).toLocaleString() }}
                </small>
              </div>
            </router-link>

            <div
              v-if="activity.activity_details_count > 0"
            >
              <span style="color: green; font-weight: 500"
                >SUBMITTED</span
              >
          </div>
          <div v-if="activity.activity_details_count <= 0">
              <span style="color: red; font-weight: 500"
                >DUE ON {{ new Date(activity.duedate).toLocaleString() }}</span
              >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
    name:'class-work-student',
    props:["activity"]
}
</script>
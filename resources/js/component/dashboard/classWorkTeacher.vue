<template>
  <div class="card my-2" style="width: 100%;padding: 5px;">
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
                    <router-link
                    :to="{
                        name: 'activityViewTeacher',
                        params: {
                        class_id: activity.class_id,
                        activity_id: activity.id,
                        },
                    }"
                    >
                        <div
                            class="mx-2"
                            style="display: flex; flex-direction: column"
                        >
                            <h5 class="card-title mb-0">
                            <b class="comment"
                                >{{ activity.user.fname }} Posted a new
                                {{
                                activity.category == "A"
                                    ? "ACTIVITY"
                                    : activity.category == "E"
                                    ? "EXAM"
                                    : "QUIZ"
                                }}: {{ activity.title }}</b
                            >
                            </h5>
                            <h6 class="card-title mb-0">
                                <i>{{ activity.class.code }}</i> 
                                <b>{{ activity.class.name }}</b>
                            </h6>
                            <small class="text-muted mt-0">
                            Posted
                            {{ new Date(activity.created_at).toLocaleString() }}
                            </small>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name:'class-work-teacher',
    props:["activity"]
}
</script>

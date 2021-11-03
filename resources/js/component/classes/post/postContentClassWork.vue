<template>
  <div>
    <!-- start loop -->
    <div class="card">
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
              <router-link
                :to="{
                  name: 'activityView',
                  params: { class_id: class_id, activity_id: activity_id },
                }"
              >
                <div class="mx-2" style="display: flex; flex-direction: column">
                  <h6 class="card-title mb-0">
                    <b class="comment" id="post-user"
                      >{{ teacher }} Posted a new classwork: {{ title }}</b
                    >
                  </h6>
                  <small class="text-muted mt-0">
                    Posted
                    {{ new Date(postedDate).toLocaleString() }}
                  </small>
                </div>
              </router-link>

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
  ],
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
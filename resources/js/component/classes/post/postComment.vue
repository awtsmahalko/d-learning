<template>
  <div class="card-footer mx-0 px-1" v-if="comments.length > 0">
    <div style="width: 100%">
      <div class="col-md-12">
        <h6>
          <b>{{ comments.length }}</b> class comments
        </h6>
      </div>
      <!-- <div v-if="posts.length > 0">
            <div v-for="(comment, key) in comments" :key="key" class="card"> -->
      <!-- start loop -->
      <!-- start loop -->
      <div class="col-md-12 mt-3" v-for="(comment, key) in comments" :key="key">
        <div class="d-flex">
          <div class="flex-shrink-0" style="margin-top: 4px">
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
                <b id="post-user">{{ comment.user.fname }}</b>

                <small class="card-category mt-0 text-muted">
                  {{ new Date(comment.created_at).toLocaleString() }}
                </small>
              </h6>
              <p class="comment mt-0" v-html="comment.message"></p>
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
</template>
<script>
export default {
  props: ["comments"],
};
</script>
<style scoped>
.comment {
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 2px;
  white-space: break-spaces;
}

.dropdown-toggle::after {
  content: none !important;
}
</style>
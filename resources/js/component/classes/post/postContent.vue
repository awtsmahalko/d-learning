<template>
  <div>
    <div class="card-header card-header-icon">
      <div class="row">
        <div
          class="col-md-12"
          style="
            display: flex;
            width: 100px;
            justify-content: space-between;
            flex-direction: row;
            align-items: center;
          "
        >
          <div class="card-icon p-0">
            <img
              class="post-avatar"
              src="http://via.placeholder.com/300x180"
              alt="Card image cap"
              style="
                width: 70px;
                height: 75px;
                object-fit: cover;
                border-top-left-radius: 3px;
                border-bottom-left-radius: 3px;
              "
            />
          </div>
          <div
            style="
              display: flex;
              flex-direction: column;
              width: calc(100% - 10%);
            "
          >
            <h4 class="card-title mb-0">
              <b id="post-user">{{ userposted }}</b>
            </h4>
            <small class="card-category mt-0 text-muted">
              {{ dateposted }}
            </small>
          </div>
          <div class="ms-auto">
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
    <div class="card-body" style="padding-top: 0px">
      <p class="post-description" v-html="descriptionposted"></p>
      <div class="col-md-12">
        <div class="row">
          <postContentAttachment />
          <postContentAttachment />
        </div>
      </div>
    </div>
    <div class="card-footer mx-0 px-1">
      <!-- <div class="col-md-12">
        <div class="row">asd</div>
      </div> -->
      <div class="stats">
        <i class="material-icons">access_time</i>
        <input type="text" style="width: 100%" />
      </div>
    </div>
  </div>
</template>
<script>
import postContentAttachment from "./postAttachment.vue";

export default {
  props: ["userposted", "dateposted", "descriptionposted"],
  components: {
    postContentAttachment,
  },
};
</script>
<style scoped>
.post-description {
  color: #5a5a5a;
  font-weight: 410;
}

.dropdown-toggle::after {
  content: none !important;
}

.post-avatar {
  border: 1px solid #c4c0c0;
  border-radius: 3px;
}

.card-footer {
  border-top: 1px solid #ddd !important;
}
</style>
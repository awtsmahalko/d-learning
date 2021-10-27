<template>
  <div class="container mt-3">
    <div class="col-md-12">
      <button type="submit" class="btn btn-md btn-primary">
        <span class="material-icons"> add </span> Create
      </button>
    </div>
    <div class="col-md-12">
      <div class="card my-2">
        <div style="width: 100%padding: 11px;">
          <!-- start loop -->
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
                <div class="mx-2" style="display: flex; flex-direction: column">
                  <h6 class="card-title mb-0">
                    <b class="comment" id="post-user">Assignment #1</b>
                  </h6>
                  <small class="text-muted mt-0"> Posted Aug 15, 2018 </small>
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
    </div>
  </div>
</template>
<script>
</script>
<style scoped>
.comment {
  font-size: 14px;
  font-weight: 800;
  margin-bottom: 2px;
  white-space: break-spaces;
}

.dropdown-toggle::after {
  content: none !important;
}
</style>

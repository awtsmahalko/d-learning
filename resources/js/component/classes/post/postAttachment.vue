<template>
  <div class="card file-attachment">
    <div class="card-horizontal" style="display: flex; flex-direction: row">
      <img
        class=""
        src="http://via.placeholder.com/300x180"
        alt="Card image cap"
        style="
          width: 120px;
          object-fit: cover;
          border-top-left-radius: 3px;
          border-bottom-left-radius: 3px;
        "
      />

      <div class="card-body" style="padding: 11px">
        <div class="row">
          <div
            class="col-12"
            style="
              display: flex;
              width: 100px;
              justify-content: space-between;
              flex-direction: row;
              align-items: center;
            "
          >
            <div
              style="display: flex; flex-direction: column; width: calc(77%)"
            >
              <h5
                class="card-title"
                style="
                  text-overflow: ellipsis;
                  width: 100%;
                  white-space: nowrap;
                  overflow: hidden;
                "
              >
                <b
                  >test_attachment_for_classtest_attachment_for_classtest_attachment_for_classtest_attachment_for_classtest_attachment_for_classtest_attachment_for_classtest_attachment_for_class.jpg</b
                >
              </h5>
              <p class="card-text text-muted">Image</p>
            </div>

            <a class="attachment-remove">
              <i class="material-icons attachment-remove-icon">close</i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.file-attachment {
  border: 1px solid #c4c0c0;
  margin: 5px;
}

.post-description {
  color: #5a5a5a;
  font-weight: 410;
}

.attachment-remove {
  cursor: default;
}

.attachment-remove-icon {
  font-size: 1.1rem;
  color: #f44336;
  padding: 0.40625rem 1.25rem;
}
</style>

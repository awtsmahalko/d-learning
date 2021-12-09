<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row" v-if="classes.length > 0">
        <div
          class="col-lg-4 col-md-6 col-sm-6"
          v-for="(clas, key) in classes"
          :key="key"
        >
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">books</i>
              </div>
              <p class="card-category">{{ clas.code }}</p>
              <h3 class="card-title">{{ clas.name }}</h3>
              <p class="card-category">{{ clas.description }}</p>
                <div>
                    <router-link
                        :to="{
                        name: 'classView',
                        params: { id: clas.id },
                        }"
                        class="btn btn-block btn-sm btn-success"
                        ><span class="material-icons">visibility</span> View Class</router-link
                    >
                </div>
            </div>
            <div class="card-footer">
              <div class="stats" v-if="category == 'T'">
                <i class="material-icons text-primary">people</i>
                <router-link
                  :to="{ name: 'classlistView', params: { id: clas.id } }"
                  >{{ clas.class_lists.length }} students enrolled</router-link
                >
              </div>
              <div class="stats">
                <i class="material-icons text-primary">videocam</i>
                <router-link
                  :to="{ name: 'videoView', params: { id: clas.id } }"
                  >{{ clas.meetings.length }} meetings</router-link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "user-class-index",
  data() {
    return {
      classes: [],
      category:''
    };
  },
  mounted() {
    this.category = sessionCategory;
    this.fetchClasses();
  },
  methods: {
    fetchClasses() {
      axios.get(baseUrl + "/api/class/view/record", {
        params: {
          user_id: sessionUserId,
          category: sessionCategory,
        },
      })
      .then((data) => {
        this.classes = data.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
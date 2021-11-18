<template>
  <div class="meeting">
    <div class="container-zoom">
      <ZoomFrame :meetId="meetId" :meetingId="meetingId" :password="password" :classId="classId"/>
    </div>
  </div>
</template>

<script>
import ZoomFrame from "./zoomFrame";

export default {
  name: "app",
  data: function () {
      return {
        meetId:'',
        meetingId:'',
        classId:'',
        password:''
      }
  },
  components: {
    ZoomFrame,
  },
  created : function (){
      this.meetId = this.$route.params.id;
      this.meetingId = this.$route.params.number;
      this.password = this.$route.params.password;
      this.classId = this.$route.params.class_id;
  },
  methods : {
     fetchCredential(){
      axios
        .get(baseUrl + "/api/video/"+this.meetId)
        .then((response) => {
          this.meetingId = response.data.number;
          this.password = response.data.password;

          console.log(this.meetingId);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },
};
</script>

<style>
.container-zoom {
  width: 70%;
  height: 100%;
}
</style>
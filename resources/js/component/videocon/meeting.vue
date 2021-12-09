<template>
  <div class="meeting">
    <div class="container-zoom">
      <ZoomFrame :meetId="meetId" :meetingId="meetingId" :password="password" :classId="classId" :apiKey="apiKey" :apiSecret="apiSecret"/>
    </div>
    <div><button @click="recordVideo" id="btn_record" class="btn btn-danger" style="z-index: 1000;position: fixed;top:7px;right: 60px;"><span class="material-icons">radio_button_checked</span>  Record</button></div>
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
        password:'',
        apiKey:'',
        apiSecret:''
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
      this.apiKey = this.$route.params.api_key;
      this.apiSecret = this.$route.params.api_secret;
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
    },
    async recordVideo(){
      let stream = await navigator.mediaDevices.getDisplayMedia({
          video: true
        })

        //needed for better browser support
        const mime = MediaRecorder.isTypeSupported("video/webm; codecs=vp9") 
                  ? "video/webm; codecs=vp9" 
                  : "video/webm"
          let mediaRecorder = new MediaRecorder(stream, {
              mimeType: mime
          })

          let chunks = []
          mediaRecorder.addEventListener('dataavailable', function(e) {
              chunks.push(e.data)
          })

          mediaRecorder.addEventListener('stop', function(){
            let blob = new Blob(chunks, {
                type: chunks[0].type
            })
            let url = URL.createObjectURL(blob)

            //let video = document.querySelector("video")
            //video.src = url

            let a = document.createElement('a')
            a.href = url
            a.download = 'dlearning.webm'
            a.click()

            document.getElementById("btn_record").innerHTML = "Stopped Sharing. Video Downloaded.";
        })

          document.getElementById("btn_record").innerHTML = "Recording ...";

          //we have to start the recorder manually
          mediaRecorder.start()
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
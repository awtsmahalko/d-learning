<template>
  <div class="iframe-container">
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.9/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.9/css/react-select.css" />

    <meta name="format-detection" content="telephone=no">
  </div>
</template>
<script>
$(".sidebar").remove();
$('.navbar').remove();
import { ZoomMtg } from "../../../../node_modules/@zoomus/websdk";

console.log("checkSystemRequirements");
console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

// CDN version default
ZoomMtg.setZoomJSLib('https://source.zoom.us/1.9.9/lib', '/av'); 

ZoomMtg.preLoadWasm();

ZoomMtg.prepareJssdk();

var API_KEY = 'xE4RMY1iRDCbzXL0hfgQ_A';

var API_SECRET = 'zdxTw3HhPPWFStKXNQ3IY5JrYOkcbyfb06zC';

var role = sessionCategory == 'T' ? 1 : 0;
var url = baseUrl == '' ? "http://127.0.0.1:8000/video/view/": "https://juancoder.com/dlearning/video/view/";

export default {
  name: "ZoomFrame",
  data: function() {
    return {
      src: "",
      meetConfig: {},
      signature: {}
    };
  },
  props: {
    nickname: String,
    meetingId: String,
    password: String,
    meetId: String
  },
  created: function() {
    // Meeting config object
    this.meetConfig = {
      signatureEndpoint: url+this.meetId,
      apiKey: API_KEY,
      apiSecret: API_SECRET,
      meetingNumber: this.meetingId,
      userName: this.nickname,
      passWord: this.password,
      leaveUrl: url+this.meetId,
      role: role
    };

    // Generate Signature function
    this.signature = ZoomMtg.generateSignature({
      meetingNumber: this.meetConfig.meetingNumber,
      apiKey: this.meetConfig.apiKey,
      apiSecret: this.meetConfig.apiSecret,
      role: this.meetConfig.role,
      success: function(res) {
        // eslint-disable-next-line
        console.log("success signature: " + res.result);
      }
    });

    // join function
    ZoomMtg.init({
      leaveUrl: this.meetConfig.leaveUrl,
      isSupportAV: true,
      success: () => {
        ZoomMtg.join({
          meetingNumber: this.meetConfig.meetingNumber,
          userName: this.meetConfig.userName,
          signature: this.signature,
          apiKey: this.meetConfig.apiKey,
          userEmail: "email@gmail.com",
          passWord: this.meetConfig.passWord,
          success: function(res) {
            // eslint-disable-next-line
            console.log("join meeting success");
          },
          error: function(res) {
            // eslint-disable-next-line
            console.log(res);
          }
        });
      },
      error: function(res) {
        // eslint-disable-next-line
        console.log(res);
      }
    });
  },
  mounted: function() {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
<template>
  <div class="wrapper">
    <div class="main-panel">
        <join-meeting></join-meeting>
    </div>
  </div>
</template>
<script>
import joinMeeting from './videocon/joinMeeting.vue'
export default {
  components: { joinMeeting },
    name:'meeting'
}
</script>

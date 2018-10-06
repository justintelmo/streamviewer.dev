<style>

</style>

<template>
  <div class="row">
    <div class="col-sm-6">
      <a :href="'#/stats/' + $route.params.id + '/' + this.chatId">View stats</a>
      <iframe width="600" height="337.5" :src="'https://www.youtube.com/embed/' + $route.params.id + '?autoplay=1'" frameborder="0" allowfullscreen></iframe><br/>
    </div>
    <div class="col-sm-6">
      Current viewers: {{ viewers }}
      <iframe width="400" height="700" :src="'https://www.youtube.com/live_chat?v=' + $route.params.id + '&output=embed&embed_domain=' + domain" allowfullscreen="" frameborder="0"></iframe>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        domain: document.domain,
        viewers: null,
        chatId: null
      }
    },

    mounted() {
      axios.get('http://localhost:8000/api/v1/streams/' + this.$route.params.id)
      .then(
        response => {
          console.log(response);
          this.chatId = response.data.stream.items[0].liveStreamingDetails.activeLiveChatId;
          this.viewers = response.data.stream.items[0].liveStreamingDetails.concurrentViewers;
          console.log(this.viewers);
        }
      )
    }
  }
</script>
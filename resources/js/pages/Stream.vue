<style>
.right-align {
  float: right;
}

.left-align {
  float: left;
}
</style>

<template>
  <div class="container">
    <div class="row">
      <a class="left-align" :href="'#/stats/' + $route.params.id + '/' + this.chatId">View stats</a>
      <p class="text-right">Current viewers: {{ viewers }}</p>
      <div style="clear: both;"></div>
    </div>
    <div class="col-sm-6">
      <iframe width="720" height="480" :src="'https://www.youtube.com/embed/' + $route.params.id + '?autoplay=1'" frameborder="0" allowfullscreen></iframe><br/>
    </div>
    <div class="col-sm-6">
      <iframe width="600" height="350" :src="'https://www.youtube.com/live_chat?v=' + $route.params.id + '&output=embed&embed_domain=' + domain" allowfullscreen="" frameborder="0"></iframe>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        domain: document.domain,
        viewers: null,
        chatId: null,
        chatPageToken: '',
      }
    },

    methods: {
      startChatMessagePolling: function () {
        var self = this;
        console.log("Start message polling");
        console.log("Chat Id: " + self.chatId);
        console.log("Chat Page Token: " + self.chatPageToken);
        axios.get('http://localhost:8000/api/v1/messages/' + self.chatId + "/" + self.chatPageToken)
        .then(
          response => {
            console.log(response);
            self.messages = response.data.messages.items;
            self.chatPageToken = response.data.messages.nextPageToken;
            axios.post('http://localhost:8000/api/v1/messages', response.data.messages.items);
            console.log("Time to next request: " + response.data.messages.pollingIntervalMillis);
            setTimeout(self.startChatMessagePolling, response.data.messages.pollingIntervalMillis);
          }
        )
        clearTimeout();
      }
    },


    mounted() {
      var self = this;
      axios.get('http://localhost:8000/api/v1/streams/' + this.$route.params.id)
      .then(
        response => {
          console.log(response);
          self.chatId = response.data.stream.items[0].liveStreamingDetails.activeLiveChatId;
          self.viewers = response.data.stream.items[0].liveStreamingDetails.concurrentViewers;
          setTimeout(self.startChatMessagePolling(), 1);
        }
      )
    }
  }
</script>
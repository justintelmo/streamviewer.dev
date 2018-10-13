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
      <div class="container">
        <div class="col-sm-3">
          <a class="btn btn-primary left-align" :href="'#/stats/' + $route.params.id + '/' + this.chatId">View stats</a>
        </div>
        <div class="col-sm-9">
          <p class="right-align">Current viewers: {{ viewers }}</p>
        </div>
      </div>
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
import { STREAMVIEWER_CONFIG } from "../config.js";
export default {
  data() {
    return {
      domain: document.domain,
      viewers: null,
      chatId: null,
      chatPageToken: ""
    };
  },

  methods: {
    startChatMessagePolling: function() {
      var self = this;
      axios
        .get(
          STREAMVIEWER_CONFIG.API_URL +
            "/messages/" +
            self.chatId +
            "/" +
            self.chatPageToken
        )
        .then(response => {
          self.messages = response.data.messages.items;
          self.chatPageToken = response.data.messages.nextPageToken;
          axios.post(
            STREAMVIEWER_CONFIG.API_URL + "/messages",
            response.data.messages.items
          );
          setTimeout(
            self.startChatMessagePolling,
            response.data.messages.pollingIntervalMillis
          );
        });
      clearTimeout();
    }
  },

  mounted() {
    var self = this;
    axios
      .get(STREAMVIEWER_CONFIG.API_URL + "/streams/" + this.$route.params.id)
      .then(response => {
        self.chatId =
          response.data.stream.items[0].liveStreamingDetails.activeLiveChatId;
        self.viewers =
          response.data.stream.items[0].liveStreamingDetails.concurrentViewers;
        setTimeout(self.startChatMessagePolling(), 1);
      });
  }
};
</script>
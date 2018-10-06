<style>

</style>

<template>
  <div class="container">
    <div v-for="message in messages">
      [{{message.snippet.publishedAt}}] {{ message.authorDetails.displayName }}: {{message.snippet.textMessageDetails.messageText}} 
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        domain: document.domain,
        liveStreamingDetails: null,
        messages: null
      }
    },

    mounted() {
      axios.get('http://localhost:8000/api/v1/messages/' + this.$route.params.chatId)
      .then(
        response => {
          this.messages = response.data.messages.items;
          console.log(this.messages);
          axios.post('http://localhost:8000/api/v1/messages', response.data);
        }
      )

      axios.get('http://localhost:8000/api/v1/streams/' + this.$route.params.id)
      .then(
        response => {
          let data = response.data.stream.items[0];
          this.liveStreamingDetails = data.liveStreamingDetails;
          this.snippet = data.snippet;
        }
      )
    }
  }
</script>
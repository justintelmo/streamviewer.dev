<style>

</style>

<template>
  <div class="container">
    <div v-for="message in messages">
      [{{message.published_at}}] {{ message.display_name }}: {{message.content}} 
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
      axios.get('http://localhost:8000/api/v1/stats/' + this.$route.params.chatId)
      .then(
        response => {
          this.messages = response.data.messages.data;

          this.messages.forEach(message => {
            let date = new Date(message.published_at * 1000);
            date = date.toLocaleString();
            message.published_at = date.toString();
          });
          console.log(this.messages);
          // axios.post('http://localhost:8000/api/v1/messages', response.data);
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
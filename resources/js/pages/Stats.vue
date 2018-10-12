<style>
</style>

<template>
  <div class="container">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col" @click="sort('username')">Display Name</th>
          <th scope="col" @click="sort('content')">Message</th>
          <th scope="col" @click="sort('timestamp')">Posted At</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="message in messages">
          <td>{{message.display_name}}</td>
          <td>{{message.content}}</td>
          <td>{{message.published_at}}</td>
        </tr>
      </tbody>

    </table>
      <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchMessages()"></pagination>
  </div>
</template>

<script>
import { STREAMVIEWER_CONFIG } from "../config.js";
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      domain: document.domain,
      liveStreamingDetails: null,
      messages: null,
      pagination: {
        current_page: 1
      }
    };
  },
  components: {
    Pagination
  },
  methods: {
    fetchMessages() {
      axios
        .get(
          STREAMVIEWER_CONFIG.API_URL +
            "/stats/" +
            this.$route.params.chatId +
            "?page=" +
            this.pagination.current_page
        )
        .then(response => {
          this.messages = response.data.data.data;
          this.pagination = response.data.pagination;
        })
        .catch(error => {
          console.log(error.response.data);
        });
    },

    fetchChannelDetails() {
      axios
        .get(STREAMVIEWER_CONFIG.API_URL + "/streams/" + this.$route.params.id)
        .then(response => {
          let data = response.data.stream.items[0];
          this.liveStreamingDetails = data.liveStreamingDetails;
          this.snippet = data.snippet;
        });
    }
  },

  mounted() {
    this.fetchMessages();
    this.fetchChannelDetails();
  }
};
</script>
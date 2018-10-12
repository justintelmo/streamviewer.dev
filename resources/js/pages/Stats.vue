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
        <tr v-for="message in sortedMessages">
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
  computed: {
    sortedMessages() {
      if (!this.messages) {
        return 0;
      }

      return this.messages.sort((a, b) => {
        let modifier = 1;
        if (this.currentSortDir == "desc") modifier = -1;
        if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;

        return 0;
      });
    }
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
    },

    sort(category) {
      if (category === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = category;
    }
  },

  mounted() {
    this.fetchMessages();
    this.fetchChannelDetails();
  }
};
</script>
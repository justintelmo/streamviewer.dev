<style>
.modalLoader {
  display: block;
  /* position: fixed; */
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  opacity: 0.4;
  background-color: rgba(0, 0, 0, 0.4);
}

table thead th {
  font-size: 1.2em;
}

tbody tr:nth-child(even) {
  background: #e0e0e0 !important;

  color: rgb(0, 0, 0);
}

table {
  border-collapse: separate;
  border: solid #d3d2d2 4px;
  border-radius: 6px;
  -moz-border-radius: 6px;
}

td,
th {
  border-left: solid black 1px;
  border-top: solid black 1px;
}

th {
  border-top: none;
}

td:first-child,
th:first-child {
  border-left: none;
}

tbody td {
  border-left: 2px solid black;
  border-right: 2px solid black;
}

/* div {
  background-color: #1e2326;
} */

.pagination-previous {
  background: white;
}

.pagination-next {
  background: white;
}

.pagination-link {
  background: #31c3a2;
}
</style>

<template>
  <div class="container">
    <div class="container">
      <div class="col-sm-12">
        <a class="btn btn-primary left-align" :href="'#/streams/' + $route.params.id">View stream</a>
        <input v-model="search" placeholder="Look by username..." v-on:blur="fetchMessages()">
      </div>
    </div>
    <table class="table table-sm">
      <thead>
        <tr>
          <th class="tableHeader" scope="col" @click="fetchMessagesSortedBy('display_name')">Display Name</th>
          <th class="tableHeader" scope="col" @click="fetchMessagesSortedBy('content')">Message</th>
          <th class="tableHeader" scope="col" @click="fetchMessagesSortedBy('published_at')">Posted At</th>
        </tr>
      </thead>

      <tbody>
        <div class="modalLoader" v-if="loading">
          <div class="modalBg"></div>
          <img src="https://loading.io/spinners/spin/lg.ajax-spinner-gif.gif">
        </div>
        <tr v-for="message in messages" v-else>
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
      },
      currentSort: "published_at",
      currentSortDir: "desc",
      loading: false,
      search: null
    };
  },
  components: {
    Pagination
  },
  methods: {
    buildUrl() {
      let url =
        STREAMVIEWER_CONFIG.API_URL +
        "/stats?chatId=" +
        this.$route.params.chatId;

      if (this.search) {
        url += "&search=" + this.search;
      }

      if (this.currentSortDir) {
        url += "&sortDir=" + this.currentSortDir;
      }

      if (this.currentSort) {
        url += "&sortBy=" + this.currentSort;
      }

      url += "&page=" + this.pagination.current_page;

      return url;
    },

    fetchMessagesSortedBy(sortBy) {
      if (this.currentSortDir === "desc") {
        this.currentSortDir = "asc";
      } else {
        this.currentSortDir = "desc";
      }
      this.currentSort = sortBy;
      this.fetchMessages();
    },

    fetchMessages() {
      this.loading = true;
      console.log(this.sortBy);
      axios
        .get(this.buildUrl())
        .then(response => {
          console.log("Done loading!");
          this.loading = false;
          this.messages = response.data.data.data;
          this.pagination = response.data.pagination;
        })
        .catch(error => {
          this.loading = false;
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
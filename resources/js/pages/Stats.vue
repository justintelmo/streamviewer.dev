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
div {
  background-color: #1e2326;
}

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
      loading: false
    };
  },
  components: {
    Pagination
  },
  methods: {
    fetchMessagesSortedBy(sortBy) {
      if (this.currentSortDir === "desc") {
        this.currentSortDir = "asc";
      } else {
        this.currentSortDir = "desc";
      }

      axios
        .get(
          STREAMVIEWER_CONFIG.API_URL +
            "/stats/" +
            this.$route.params.chatId +
            "/" +
            sortBy +
            "/" +
            this.currentSortDir +
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
    fetchMessages() {
      this.loading = true;
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
          this.loading = false;
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
    },
    sort(s) {
      if (s === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = s;
    }
  },

  mounted() {
    this.fetchMessages();
    this.fetchChannelDetails();
  }
};
</script>
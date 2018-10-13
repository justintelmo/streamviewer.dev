<style>
#streamsContainer {
  width: 100%;
  height: 75%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

.streamBox {
  width: 180px;
  height: 240px;
  border-radius: 5px;
  word-wrap: break-word;
  font-size: 0.9em;
}

.thumbnail {
  height: 90px;
}

a {
  font-size: 14px;
  color: rgb(200, 200, 200);
}

a:hover {
  text-decoration: none;
  color: #fff;
}

.stream-title {
  font-size: 2.5em;
  text-align: center;
  line-height: 50px;
}

div {
  background-color: #1e2326;
}

.stream-title {
  color: #fff;
}
</style>

<template>
  <div class="container">
    <div class="col-sm-12">
      <p class="stream-title">Top Streams</p>
    </div>
    <div class="row" v-for='streamGroup in groupedStreams'>
      <div v-for='stream in streamGroup' class="streamBox col-lg-2">
        <img :src="stream.snippet.thumbnails.medium.url" class="thumbnail">
        <div>
          <a :href="'#/streams/' + stream.id.videoId">{{ stream.snippet.title }}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import { STREAMVIEWER_CONFIG } from "../config.js";
export default {
  data() {
    return {
      streams: null
    };
  },
  mounted() {
    axios.get(STREAMVIEWER_CONFIG.API_URL + "/streams").then(response => {
      this.streams = response.data.streams.items;
    });
  },
  computed: {
    groupedStreams() {
      return _.chunk(this.streams, 6);
    }
  }
};
</script>
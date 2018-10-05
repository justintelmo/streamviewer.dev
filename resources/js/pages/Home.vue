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
    height: 300px;
    border-radius: 5px;
    border: 1px solid black;
    word-wrap: break-word;
  }

  .thumbnail {
    height: 90px;
  }
</style>

<template>
  <div class="container">
      <div class="streamBox col-sm-3" v-for='stream in streams'>
          <img :src="stream.snippet.thumbnails.medium.url" class="thumbnail">
          <a :href="'#/streams/' + stream.id.videoId">{{ stream.snippet.title }}</a>
      </div>
  </div>
</template>

<script>
  import Vue from "vue";
  import axios from "axios";
  export default {
    data() {
      return {
        streams: null
      };
    },
    mounted() {
      axios
      .get('http://localhost:8000/api/v1/streams')
      .then(response => {
        console.log(response);
        this.streams = response.data.streams.items;
      });
    }
  }
</script>
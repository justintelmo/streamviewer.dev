<style>
</style>

<template>
  <div>
      You've been logged out.
  </div>
</template>

<script>
import { STREAMVIEWER_CONFIG } from "../config.js";
export default {
  mounted() {
    axios
      .get(STREAMVIEWER_CONFIG.WEB_URL + "/logout")
      .then(response => {
        document.location.href = "/";
      })
      .catch(e => {
        console.log(e);
      });
  }
};
</script>
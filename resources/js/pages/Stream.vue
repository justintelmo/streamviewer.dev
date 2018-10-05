<style>

</style>

<template>
  <div class="row">
    <a :href="'#/stats/' + $route.params.id">View stats</a>
    <div class="col-sm-6">
        <iframe width="600" height="337.5" :src="'https://www.youtube.com/embed/' + $route.params.id + '?autoplay=1'" frameborder="0" allowfullscreen></iframe><br/>
    </div>
    <div class="col-sm-6">
        <iframe width="400" height="700" :src="'https://www.youtube.com/live_chat?v=' + $route.params.id + '&output=embed&embed_domain=' + domain" allowfullscreen="" frameborder="0"></iframe>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        domain: document.domain
      }
    },

    mounted() {
      axios.get('api/v1/streams/' + this.$route.params.id)
      .then(
        response => {
          console.log(response);
        }
      )
    }
  }
</script>
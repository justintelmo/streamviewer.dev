<style>

</style>

<template>
  <div>

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
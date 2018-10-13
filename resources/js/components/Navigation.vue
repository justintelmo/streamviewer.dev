<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-default bg-default">
            <router-link class="navbar-brand" to="/">Stream Viewer</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/logout">Logout</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
  props: ["username"],
  data() {
    return {
      username: ""
    };
  },
  mounted() {
    console.log(this.username);
  }
};
</script>

<style>
</style>
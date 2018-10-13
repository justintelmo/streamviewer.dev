<style>
</style>

<template>
    <div id="app-layout">
        <navigation username={{ Auth::user()->name }}></navigation>

        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from "../components/Navigation.vue";

export default {
  components: {
    Navigation
  }
};
</script>
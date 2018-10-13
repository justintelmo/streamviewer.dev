
<style>
#navbarNav {
  position: relative;
  margin: 0 auto;
  text-align: right;
  background-color: #1e2326;
}

#navbarNav > ul {
  position: absolute;
  left: 90%;
}

.navbar {
  background-color: #1e2326;
}
li {
  margin-right: 10px;
}

a {
  color: rgb(124, 124, 124);
}

a:hover {
  color: #fff;
}

* {
  font-family: "Roboto", sans-serif;
}
</style>
<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-default bg-default">
            <router-link class="navbar-brand" to="/" aria-disabled="true">Stream Viewer</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link btn btn-primary" to="/">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link btn btn-danger" to="/logout">Logout</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
</script>

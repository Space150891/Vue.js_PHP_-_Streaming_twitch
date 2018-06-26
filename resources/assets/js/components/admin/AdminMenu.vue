<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" v-if="checkToken">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#/item-types">Item-types <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <nav v-else>
        <a class="navbar-brand" href="#/login">Login</a>
    </nav>
  </div>
</template>
<script>
    export default {
        data() {
            return {
                count: 0,
                
            }
        },
        mounted() {

        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
        },
    }
</script>
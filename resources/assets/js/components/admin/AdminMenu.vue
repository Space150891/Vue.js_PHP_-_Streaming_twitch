<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" v-if="checkToken">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/item-types')}" href="#/item-types" >Item-types</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/rarities')}" href="#/rarities" >Rarities</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/items')}" href="#/items" >Items</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/case-types')}" href="#/case-types" >Case Types</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/cases')}" href="#/cases" >Cases</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/streamers')}" href="#/streamers" >Streamers</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/promoted')}" href="#/promoted" >Promouted Streamers</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/main-streamers')}" href="#/main-streamers" >Main Streamers</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/main-content')}" href="#/main-content" >Main Content</a>
          </li>
          <li class="nav-item">
            <a v-bind:class="{'nav-link' : true , 'active' : (page == '/logout')}" href="#/logout" >LOGOUT</a>
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
        props: {
          page: {
            type: String,
            default: '/',
            required: false
          },
        },
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
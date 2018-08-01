<template>
<div
  v-if="links.length > 0"
  class="menu-dropdown"
>
    <div
      v-if="links.length > 1"
      class="dropdown"
    >
        <button
          class="btn btn-secondary dropdown-toggle"
          @click.prevent="mainClick()"
        >
            {{ mainLabel }}
        </button>

        <div
          v-if="viewList"
          class="dropdown-menu"
          v-bind:style="viewList ? 'display:block' : 'display:none'"
        >
            <a
              v-if="links.length > 1"
              v-for="link in links"
              class="dropdown-item"
              v-bind:href="getUrl(link)"
              @click.prevent="linkClick(link)"
            >
                {{ link }}
            </a>
        </div>
    </div>
    <a
      v-if="links.length == 1"
      v-bind:href="getUrl(links[0])"
      class="btn btn-secondary"
      @click.prevent="linkClick(links[0])"
    >
        {{ mainLabel }}
    </a>
</div>
</template>

<script>
    export default {
        props: ['mainLabel', 'baseUrl', 'links'],
        data(){
            return {
                viewList : false,
            }
        },
        methods: {
            getUrl(link) {
              return '#/' + this.baseUrl + '/' + link;
            },
            mainClick() {
                this.viewList = !this.viewList;
            },
            linkClick(link) {
                this.viewList = false;
                this.$store.commit('clearWatchingStreams');
                window.location = this.getUrl(link);
            },
        }
    }
</script>
<style>
.menu-dropdown {
    margin: -18px 10px 0 0;
}
</style>
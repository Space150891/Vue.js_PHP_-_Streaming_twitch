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
            Follow Stream
        </button>

        <div
          v-if="viewList"
          class="dropdown-menu"
          v-bind:style="viewList ? 'display:block' : 'display:none'"
        >
            <a
              v-if="links.length > 1"
              v-for="link in links"
              :key="link"
              class="dropdown-item"
              href="#"
              @click.prevent="linkClick(link)"
            >
                {{ link }}
            </a>
        </div>
    </div>
    <a
      v-if="links.length == 1"
      href="#"
      class="btn btn-secondary"
      @click.prevent="linkClick(links[0])"
    >
        Follow Stream
    </a>
    <modal-alert
      AlertType="success"
      v-bind:messages="['follow soccesful']"
      v-bind:opened="openAlertModal"
      v-on:close-alert-modal="openAlertModal=false"
    ></modal-alert>
</div>
</template>

<script>
    export default {
        props: ['links'],
        data(){
            return {
                viewList : false,
                openAlertModal : false,
            }
        },
        methods: {
            mainClick() {
                this.viewList = !this.viewList;
            },
            linkClick(name) {
                this.viewList = false;
                this.$store.commit('addFollow', name);
                this.openAlertModal = true;
            },
        }
    }
</script>
<style>
.menu-dropdown {
    margin: -18px 10px 0 0;
}
</style>
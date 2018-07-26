<template>
  <div v-if="alerts.length > 0">
    <div
      v-for="alert in alerts"
      class="alert alert-primary" role="alert"
    >
        {{alert.message}}
    </div>
    <button
      @click.prevent="clearAlerts()"
      class="btn btn-info pull-right"
    >
        clear
    </button>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

  export default {
    
    methods: {
		clearAlerts: function () {
            this.$store.commit('clearAlerts');
        }
    },
    computed: {
		...mapGetters([
			'alerts',
		]),
    }
  }
</script>
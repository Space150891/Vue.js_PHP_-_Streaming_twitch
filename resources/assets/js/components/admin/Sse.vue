<template>
<ul class="list-group">
  <li 
    v-for="(message, index) in sseMessages" :key="index"
    @click="deleteMessage(index)"
    class="list-group-item">
    {{message}}
    
  </li>
</ul>
</template>
<script>
  import { mapGetters} from 'vuex';

  export default {
    methods: {
		deleteMessage: function(index) {
            this.$store.commit('deleteMessage');
        }
    },
    computed: {
			...mapGetters([
				'checkToken',
                'sseMessages'
			]),
    }
  }
</script>
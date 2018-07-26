<template>
<div class="container">
  <admin-menu page="/main-content"></admin-menu>
  <div v-if="checkToken && mainContentLoaded">
        <inline-alert></inline-alert>
		<h5>Main Content</h5>
        <button 
          @click.prevent="saveAction()"
          class="btn btn-success"
        >
            SAVE
        </button>
        <label class="form-control">
            Main header
            <input v-model="mainContent.mainHeader" class="form-control">
        </label>
        <vue-editor
          v-model="mainContent.mainText"
          style="height:400px;"
          :editorToolbar="customToolbar"
        >
        </vue-editor>
	</div>
  <div v-if="checkToken && !mainContentLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  import { VueEditor } from 'vue2-editor'

  export default {
    data: () => {
      return {
            customToolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                ['link'],
                ['clean'],        
            ],
        }
    },
	mounted() {
	    if (this.checkToken) {
			this.getContent();
	    }
	},
    methods: {
			getContent: function () {
				this.$store.commit('getMainContent');
			},
            saveAction: function() {
                let data = [];
                data.push({
                    name: 'mainText',
                    content: this.mainContent.mainText
                });
                data.push({
                    name: 'mainHeader',
                    content: this.mainContent.mainHeader
                });
                this.$store.dispatch('updateMainContentAction', data);
            },
    },
    computed: {
			...mapGetters([
				'checkToken',
				'mainContent',
                'mainContentLoaded',
			]),
    }
  }
</script>
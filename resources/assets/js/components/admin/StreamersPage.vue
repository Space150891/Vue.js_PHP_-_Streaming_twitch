<template>
<div  >
  <admin-menu page="/streamers"></admin-menu>
  <div v-if="checkToken && streamersLoaded">
		<h5>Streamers</h5>
		<table class="table table-striped table-condenced">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>Game</th>
                    <th>Stream id</th>
                    <th>Promoted</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in streamers" :key="item.id">
					<td>{{item.id}}</td>
                    <td>{{item.name}}</td>
					<td>{{item.game}}</td>
                    <td>{{item.twitch_id}}</td>
                    <td>
						<span v-if="item.streamer_id">
							promoted
						</span>
					</td>
					<td>
						<button 
						  v-if="!item.streamer_id"
						  class="btn btn-xs btn-success"
						  @click.prevent="setPromoted(item.id)"
						  >
						  	set promoted
						</button>
						<button 
						  v-if="item.streamer_id"
						  class="btn btn-xs btn-danger"
						  @click.prevent="removePromoted(item.promoted_id)"
						  >
						  	remove promoted
						</button>
					</td>
				</tr>
			</tbody>
		</table>
		<pagination
		  v-bind:page="page"
		  v-bind:pages="streamersPages"
		  buttons="5"
		  v-on:load-page="loadPage($event)"
		>
		</pagination>
	</div>
  <div v-if="checkToken && !streamersLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  let config = require('../config/config.json');

  export default {
    data: () => {
      return {
			errors: [],
            page: 1,
            onPage: config.on_page,
        }
    },
	mounted() {
		if (this.checkToken) {
			this.getList();
		}
	},
    methods: {
		getList: function () {
			this.$store.commit('getPaggStreamersList', {
				page: this.page,
				onPage: this.onPage
			});
		},
		setPromoted: function (id) {
            this.$store.dispatch('addPromotedAction', id);
			this.getList();
		},
        removePromoted: function (id) {
            this.$store.dispatch('deletePromotedAction', id);
			this.getList();
		},
		loadPage: function (pageNumber) {
			this.page = pageNumber;
			this.getList();
		}
    },
    computed: {
		...mapGetters([
			'checkToken',
			'streamers',
			'streamersPages',
			'streamersLoaded',
		]),
    }
  }
</script>
<template>
<div  >
  <admin-menu page="/promoted"></admin-menu>
  <div v-if="checkToken && promotedLoaded">
		<h5>Promouted Streamers</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>Position</th>
					<th>Name</th>
					<th>Game</th>
          <th>Stream id</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in promotedStreamers" :key="item.id">
					<td>{{item.position}}</td>
          <td>{{item.name}}</td>
					<td>{{item.game}}</td>
					<td>{{item.twitch_id}}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
						<button @click.prevent="setUp(item.id)" class="btn btn-info">
							<i class="fa fa-arrow-up"></i>
						</button>
						<button @click.prevent="setDown(item.id)" class="btn btn-info">
							<i class="fa fa-arrow-down"></i>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form class="form form-inline">
				<select v-model="streamerAddId" class="form-control">
					<option value=0>Select streamer</option>
					<option v-for="streamer in streamers" v-bind:value="streamer.id" :key="streamer.id">{{streamer.name}}</option>
				</select>
				<button @click.prevent="addAction()" class="btn btn-success">Add</button>
			</form>
		</div>
		<modal-delete 
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
			>
		</modal-delete>
	</div>
  <div v-if="checkToken && !promotedLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';

  export default {
    data: () => {
      return {
			deletingItem: {
			    name: '',
				id: 0,
				openModal: false,
			},
			errors: [],
          	openAlertModal: false,
			streamerAddId: 0,
        }
    },
		mounted() {
			if (this.checkToken) {
				this.getList();
			}
		},
    methods: {
            confirmDeleteAction: function (item) {
				this.deletingItem.name = item.name;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
                this.$store.dispatch('deletePromotedAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			addAction: function () {
                this.$store.dispatch('addPromotedAction', this.streamerAddId);
			},
			getList: function () {
				this.$store.dispatch('getPromotedListAction');
			},
			setUp: function (id) {
				this.$store.dispatch('upPromotedAction', id);
			},
			setDown: function (id) {
				this.$store.dispatch('downPromotedAction', id);
			},
    },
    computed: {
			...mapGetters([
				'checkToken',
				'streamers',
				'promotedStreamers',
				'promotedLoaded',
			]),
    }
  }
</script>
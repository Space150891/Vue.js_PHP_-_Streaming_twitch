<template>
<div class="container">
  <admin-menu page="/promoted"></admin-menu>
  <div v-if="checkToken && promotedLoaded">
		<h5>Promoted Streamers</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
                    <th>Stream id</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in promotedStreamers">
					<td>{{item.streamer_id}}</td>
                    <td>{{item.name}}</td>
					<td>{{item.twitch_id}}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form class="form form-inline">
				<select v-model="streamerAddId" class="form-control">
					<option value=0>Select streamer</option>
					<option v-for="streamer in streamers" v-bind:value="streamer.id">{{streamer.name}}</option>
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
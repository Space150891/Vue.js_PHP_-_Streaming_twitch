<template>
<div  >
  <admin-menu page="/main-streamers"></admin-menu>
  <div v-if="checkToken && mainStreamersLoaded">
		<h5>Main Streamers</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>Name</th>
					<th>Time</th>
                    <th>Total min</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in mainStreamers" :key="item.id">
                    <td>{{item.name}}</td>
					<td>
                        {{item.promouted_start}} - {{item.promouted_end}}
                    </td>
                    <td>
                        {{item.duration}}
                    </td>
					<td>
						<button class="btn btn-xs btn-warning" @click.prevent="openEditModel(item)">edit</button>
                        <button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form class="form form-inline">
				<select v-model="addingItem.promouted_id" class="form-control">
					<option value=0>Select streamer</option>
					<option v-for="streamer in promotedStreamers" v-bind:value="streamer.id" :key="streamer.id">{{streamer.name}}</option>
				</select>
                From:
                <vue-timepicker v-model="addingItem.promouted_start"></vue-timepicker>
                To:
                <vue-timepicker v-model="addingItem.promouted_end"></vue-timepicker>
				<button @click.prevent="addAction()" class="btn btn-success">Add</button>
			</form>
		</div>
        <div v-if="editMode" class="edit-modal-back">
            <div class="edit-modal">
                <h3 class="text-center">{{editItem.name}}</h3>
                <div>
                    <label class="time-label">From:</label>
                    <vue-timepicker v-model="editItem.promouted_start"></vue-timepicker>
                </div>
                <div>
                    <label class="time-label">To:</label>
                    <vue-timepicker v-model="editItem.promouted_end"></vue-timepicker>
                </div>
                <div class="text-center">
                    <button v-on:click="cancelAction()"  class="btn btn-info btn-xs">Calcel</button>
                    <button v-on:click="saveAction()"  class="btn btn-success btn-xs">SAVE</button>
                </div>
            </div>
        </div>
		<modal-delete 
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
			>
		</modal-delete>
	</div>
  <div v-if="checkToken && !mainStreamersLoaded" class="v-loading"></div>
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
            addingItem: {
                promouted_id: 0,
                promouted_start : {HH: '00', mm: '00'},
                promouted_end : {HH: '00', mm: '00'},
            },
            editMode: false,
            editItem: {
                id : 0,
                name : '',
                promouted_start : {HH: '00', mm: '00'},
                promouted_end : {HH: '00', mm: '00'},
            },
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
                this.$store.dispatch('deleteMainStreamerAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			addAction: function () {
                console.log(this.addingItem);
                if (
                    this.addingItem.promouted_id > 0 
                    && (
                        (this.addingItem.promouted_start.HH === this.addingItem.promouted_start.HH 
                            && this.addingItem.promouted_start.mm <= this.addingItem.promouted_start.mm)
                        || (this.addingItem.promouted_start.HH < this.addingItem.promouted_start.HH)
                        )
                    ) {
                        this.$store.dispatch('addMainStreamerAction', this.addingItem);
                    }
                
			},
			getList: function () {
				this.$store.dispatch('getMainStreamersListAction');
			},
            openEditModel: function (item) {
                this.editItem.id = item.id;
                this.editItem.name = item.name;
                this.editItem.promouted_start.HH = item.promouted_start.substr(0, 2);
                this.editItem.promouted_start.mm = item.promouted_start.substr(3, 2);
                this.editItem.promouted_end.HH = item.promouted_end.substr(0, 2);
                this.editItem.promouted_end.mm = item.promouted_end.substr(3, 2);
                this.editMode = true;
            },
            saveAction: function() {
                this.editMode = false;
                this.$store.dispatch('updateMainStreamerAction', this.editItem);
                this.editItem.id = 0;
                this.editItem.name = '';
                this.editItem.promouted_start = {HH: '00', mm: '00'};
                this.editItem.promouted_end = {HH: '00', mm: '00'};
            },
            cancelAction: function() {
                this.editMode = false;
                this.editItem.id = 0;
                this.editItem.name = '';
                this.editItem.promouted_start = {HH: '00', mm: '00'};
                this.editItem.promouted_end = {HH: '00', mm: '00'};
            },
    },
    computed: {
			...mapGetters([
				'checkToken',
				'promotedStreamers',
				'mainStreamersLoaded',
                'mainStreamers',
			]),
    }
  }
</script>
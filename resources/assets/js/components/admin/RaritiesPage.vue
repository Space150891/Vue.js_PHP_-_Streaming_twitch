<template>
<div class="container">
  <div v-if="checkToken">
		<h5>Rarities</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
                    <th>Percent</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in Rarities">
					<td>{{item.id}}</td>
					<td>{{item.name}}</td>
                    <td>{{item.percent}}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(item)">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form v-if="editMode" class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editItem.name"  type="text">
                <input class="form-control" placeholder="Percent..." v-model="editItem.percent" type="number">
				<button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				<button @click.prevent="createCancelAction()" class="btn btn-default">cancel</button>
			</form>
			<form v-else class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="newItem.name">
                <input class="form-control" placeholder="Percent..." v-model="newItem.percent" type="number">
				<button @click.prevent="createAction()" class="btn btn-success">Create new</button>
			</form>
		</div>
		<modal-delete 
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
			>
		</modal-delete>
		 <modal-alert
          AlertType="warning"
          v-bind:messages="errors"
          v-bind:opened="openAlertModal"
          v-on:close-alert-modal="openAlertModal=false"
        >
		</modal-alert>
	</div>
  <h5 v-else>login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';

  export default {
    data: () => {
      return {
			editMode: false,
			newItem: {
				name: '',
                percent: 0,
			},
			editItem: {
				name: '',
                percent: 0,
				id: 0,
			},
			deletingItem: {
			    name: '',
				id: 0,
				openModal: false,
			},
			errors: [],
          	openAlertModal: false,
        }
    },
		mounted() {
			if (this.checkToken) {
				this.getList();
			}
		},
    methods: {
			deleteAction: function (id) {
				this.$store.dispatch('RarityDeleteAction', id);
			},
            confirmDeleteAction: function (item) {
				this.deletingItem.name = item.name;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
                this.$store.dispatch('RarityDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.name = item.name;
                this.editItem.percent = item.percent;
				this.editItem.id = item.id;
				this.editMode = true;
			},
			createAction: function () {
				this.errors = [];
                if (this.newItem.name == '') {
                    this.errors.push('name empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createRarityAction', this.newItem);
                    this.newItem.name = '';
					this.newItem.percent = 0;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
				this.$store.dispatch('getRaritiesListAction');
			},
			saveAction: function() {
				this.errors = [];
                if (this.editItem.name == '') {
                    this.errors.push('name empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('RaritySaveAction', this.editItem);
                    this.editItem.name = '';
					this.editItem.percent = 0;
					this.editItem.id = 0;
					this.editMode = false;
                } else {
                    this.openAlertModal = true;
                }
			},
			createCancelAction: function() {
				this.editMode = false;
			},
    },
    computed: {
			...mapGetters([
				'checkToken',
				'Rarities',
			]),
    }
  }
</script>
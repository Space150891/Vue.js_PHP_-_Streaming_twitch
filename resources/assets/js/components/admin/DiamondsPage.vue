<template>
<div class="container">
  <admin-menu page="/diamonds"></admin-menu>
  <div v-if="checkToken && diamondsLoaded">
		<h5>Diamonds</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>Amount</th>
					<th>Name</th>
					<th>Description</th>
                    <th>Cost</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in diamonds" :key="item.id">
					<td>{{item.name}}</td>
					<td>{{item.description}}</td>
					<td>{{item.amount}}</td>
                    <td>{{item.cost}}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(item)">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form v-if="editMode" class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editItem.name" type="test">
				<input class="form-control" placeholder="Description..." v-model="editItem.description" type="test">
                <input class="form-control" placeholder="Amount..." v-model="editItem.amount" type="number">
                <input class="form-control" placeholder="Cost..." v-model="editItem.cost" type="number">
				<button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				<button @click.prevent="createCancelAction()" class="btn btn-default">cancel</button>
			</form>
			<form v-else class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="newItem.name" type="test">
				<input class="form-control" placeholder="Description..." v-model="newItem.description" type="test">
                <input class="form-control" placeholder="Amount..." v-model="newItem.amount" type="number">
                <input class="form-control" placeholder="Cost..." v-model="newItem.cost" type="number">
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
  <div v-if="checkToken && !diamondsLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
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
				description: '',
				cost: 0,
                amount: 0,
			},
			editItem: {
				name: '',
				description: '',
				cost: 0,
                amount: 0,
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
            confirmDeleteAction: function (item) {
				this.deletingItem.name = item.name;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
                this.$store.dispatch('DiamondsDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
                this.editItem.cost = item.cost;
				this.editItem.amount = item.amount;
				this.editItem.name = item.name;
				this.editItem.description = item.description;
				this.editItem.id = item.id;
				this.editMode = true;
			},
			createAction: function () {
				this.errors = [];
                if (this.newItem.cost <= 0) {
                    this.errors.push('set cost');
                }
                if (this.newItem.amount <= 0) {
                    this.errors.push('set amount');
				}
				if (this.newItem.name.trim() == '') {
                    this.errors.push('name empty');
				}
				if (this.newItem.description.trim() == '') {
                    this.errors.push('description empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('DiamondsCreateAction', this.newItem);
					this.newItem.cost = 0
					this.newItem.amount = 0;
					this.newItem.name = '';
					this.newItem.description = '';
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
				this.$store.dispatch('getDiamondsListAction');
			},
			saveAction: function() {
				this.errors = [];
                if (this.editItem.cost <= 0) {
                    this.errors.push('set cost');
                }
                if (this.editItem.amount <= 0) {
                    this.errors.push('set amount');
				}
				 if (this.editItem.name.trim() == '') {
                    this.errors.push('name empty');
				}
				if (this.editItem.description.trim() == '') {
                    this.errors.push('description empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('DiamondsSaveAction', this.editItem);
					this.editItem.cost = 0;
                    this.editItem.diamonds = 0;
					this.editItem.id = 0;
					this.editItem.name = '';
					this.editItem.description = '';
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
				'diamonds',
				'diamondsLoaded',
			]),
    }
  }
</script>
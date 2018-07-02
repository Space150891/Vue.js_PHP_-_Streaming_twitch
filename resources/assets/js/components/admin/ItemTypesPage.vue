<template>
<div class="container">
  <admin-menu page="/item-types"></admin-menu>
  <div v-if="checkToken && itemTypesLoaded">
		<h5>Item types page</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="itemType in itemTypes">
					<td>{{itemType.id}}</td>
					<td>{{itemType.name}}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(itemType)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(itemType)">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form v-if="editMode" class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editItemType.name" type="text">
				<button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				<button @click.prevent="createCancelAction()" class="btn btn-default">cancel</button>
			</form>
			<form v-else class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="newItemType.name"  type="text">
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
	<div v-if="checkToken && !itemTypesLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
	
  export default {
    data: () => {
      return {
					editMode: false,
					newItemType: {
						name: '',
					},
					editItemType: {
						name: '',
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
			confirmDeleteAction: function (item) {
				this.deletingItem.name = item.name;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('ItemTypeDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItemType.name = item.name;
				this.editItemType.id = item.id;
				this.editMode = true;
			},
			createAction: function () {
				this.errors = [];
          if (this.newItemType.name == '') {
            this.errors.push('name empty');
          }
          if (this.errors.length == 0) {
            this.$store.dispatch('createItemTypeAction', this.newItemType);
            this.newItemType.name = '';
          } else {
            this.openAlertModal = true;
          }
				
			},
			getList: function () {
				this.$store.dispatch('getItemTypesListAction');
			},
			saveAction: function() {
				this.errors = [];
        if (this.editItemType.name == '') {
          this.errors.push('name empty');
        }
        if (this.errors.length == 0) {
          this.$store.dispatch('ItemTypeSaveAction', this.editItemType);
					this.editItemType.name = '';
					this.editItemType.id = 0;
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
				'itemTypes',
				'itemTypesLoaded',
			]),
    }
  }
</script>
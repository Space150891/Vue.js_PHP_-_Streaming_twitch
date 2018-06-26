<template>
<div class="container">
  <div v-if="checkToken">
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
						<button class="btn btn-xs btn-danger" @click.prevent="deleteAction(itemType.id)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(itemType)" data-toggle="modal" data-target="#modalItemTypes">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
			<form v-if="editMode" class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editItemType.name">
				<button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				<button @click.prevent="createCancelAction()" class="btn btn-default">cancel</button>
			</form>
			<form v-else class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="newItemType.name">
				<button @click.prevent="createAction()" class="btn btn-success">Create new</button>
			</form>
		</div>

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
					newItemType: {
						name: '',
					},
					editItemType: {
						name: '',
						id: 0,
					},
        }
    },
		mounted() {
			if (this.checkToken) {
				this.getList();
			}
		},
    methods: {
			deleteAction: function (id) {
				this.$store.dispatch('ItemTypeDeleteAction', id);
			},
			editAction: function (item) {
				this.editItemType.name = item.name;
				this.editItemType.id = item.id;
				this.editMode = true;
				//this.$store.dispatch('ItemTypeEditAction');
			},
			createAction: function () {
				this.$store.dispatch('createItemTypeAction', this.newItemType);
			},
			getList: function () {
				this.$store.dispatch('getItemTypesListAction');
			},
			saveAction: function() {
				this.$store.dispatch('ItemTypeSaveAction', this.editItemType);
				this.editMode = false;
			},
			createCancelAction: function() {
				this.editMode = false;
			},
    },
    computed: {
			...mapGetters([
				'checkToken',
				'itemTypes',
			]),
    }
  }
</script>
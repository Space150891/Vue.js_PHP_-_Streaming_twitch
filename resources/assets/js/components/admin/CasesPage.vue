<template>
<div class="container">
  <admin-menu page="/cases"></admin-menu>
  <div v-if="checkToken && !editItemsMode && casesLoaded">
		<h5>Cases page</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
                    <th>Type</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="lootCase in cases">
					<td>{{ lootCase.id }}</td>
                    <td>{{ lootCase.name }}</td>
					<td>{{ lootCase.type }}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(lootCase)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(lootCase)">edit</button>
						<button class="btn btn-xs btn-success" @click.prevent="toggleItemsListAction(lootCase)">items</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
            <form class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editCase.name" type="text">
                <select v-model="editCase.case_type_id" class="form-control">
                    <option value="0">Select case type</option>
                    <option v-for="caseType in caseTypes" v-bind:value="caseType.id">{{ caseType.name + ' cost ' + caseType.price }}</option>
                </select>
                <div v-if="editMode">
				    <button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				    <button @click.prevent="editCancelAction()" class="btn btn-default">cancel</button>
                </div>
                <button v-else @click.prevent="createAction()" class="btn btn-success">Create new</button>
			</form>
		</div>
		<modal-delete 
			v-bind:name="deletingCase.name"
			v-bind:opened="deletingCase.openModal"
			v-on:close-delete-modal="deletingCase.openModal=false"
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
  <case-items
	v-if="checkToken && editItemsMode"
	v-bind:LootCase="selectedCase"
	v-on:close-items-list="closeItemsListAction"
  >
  </case-items>
  <div v-if="checkToken && !casesLoaded && !editItemsMode" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  var config = require('../admin/config.json');
	
  export default {
    data: () => {
      return {
			editMode: false,
            editItemsMode: false,
			editCase: {
				name: '',
                description: '',
                case_type_id: 0,
				id: 0,
			},
			deletingCase: {
				name: '',
				id: 0,
				openModal: false,
			},
            errors: [],
            openAlertModal: false,
            imagesUrl : (config.baseUrl + '/storage/'),
			selectedCase: {
				id : 0,
				name : '',
			}
        }
    },
		mounted() {
			if (this.checkToken) {
				this.getList();
			}
		},
    methods: {
			confirmDeleteAction: function (lootCase) {
				this.deletingCase.name = lootCase.name;
				this.deletingCase.id = lootCase.id;
				this.deletingCase.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('CaseDeleteAction', this.deletingCase.id);
				this.deletingCase.openModal = false;
			},
			editAction: function (item) {
				this.editCase.name = item.name;
                this.editCase.case_type_id = item.case_type_id;
				this.editCase.id = item.id;
				this.editMode = true;
			},
			createAction: function () {
                this.errors = [];
                if (this.editCase.name == '') {
                    this.errors.push('name empty');
                }
                if (this.editCase.case_type_id == 0) {
                    this.errors.push('select case type');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('CaseCreateAction', this.editCase);
                    this.editCase.name = '';
                    this.editCase.case_type_id = 0;
                    this.editCase.id = 0;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('CasesListAction');
			},
			saveAction: function() {
                this.errors = [];
                if (this.editCase.name == '') {
                    this.errors.push('name empty');
                }
                if (this.editCase.case_type_id == 0) {
                    this.errors.push('select case type');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('CaseSaveAction', this.editCase);
                    this.editCase.name = '';
                    this.editCase.case_type_id = 0;
                    this.editCase.id = 0;
                    this.editMode = false;
                } else {
                    this.openAlertModal = true;
                }

			},
			createCancelAction: function() {
				this.editMode = false;
			},
			closeItemsListAction: function() {
				this.editItemsMode = false;
			},
			toggleItemsListAction : function(lootCase) {
				this.$store.dispatch('CaseItemClear');
				this.selectedCase.id = lootCase.id;
				this.selectedCase.name = lootCase.name;
				this.editItemsMode = true;
			}
    },
    computed: {
			...mapGetters([
				'checkToken',
				'caseTypes',
                'cases',
				'casesLoaded',
			]),
    }
  }
</script>
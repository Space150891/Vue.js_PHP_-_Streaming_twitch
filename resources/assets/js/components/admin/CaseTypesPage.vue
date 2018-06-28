<template>
<div class="container">
  <div v-if="checkToken">
		<h5>Case types page</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in CaseTypes">
					<td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.price }}</td>
                    <td>
                        <img 
                          v-if="item.image"
                          v-bind:src="imagesUrl + item.image"
                          v-bind:style="styleImage"
                          alt="case type image"/>
                    </td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(item)">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
            <form class="form form-inline">
				<input class="form-control" placeholder="Name..." v-model="editItem.name" type="text">
                <input class="form-control" placeholder="Price..." v-model="editItem.price" type="number">
                <div v-if="editMode">
				    <button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				    <button @click.prevent="editCancelAction()" class="btn btn-default">cancel</button>
                </div>
                <button v-else @click.prevent="createAction()" class="btn btn-success">Create new</button>
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
        <upload-image
          title="Image"
          v-bind:fileName="editItem.image"
          v-on:upload-file="uploadImage($event)"
        >
        </upload-image>
	</div>
  <h5 v-else>login first</h5>
</div>
</template>
<script>
  import { mapGetters } from 'vuex';
  var config = require('../admin/config.json');
	
  export default {
    data: () => {
      return {
			editMode: false,
			editItem: {
				name: '',
                price: 0,
                image: null,
				id: 0,
			},
			deletingItem: {
				name: '',
				id: 0,
				openModal: false,
			},
            errors: [],
            openAlertModal: false,
            image: false,
            styleImage: {
                width: "100px",
                border: "1px #888 solid",
                borderRadius: "2px",
            },
            imagesUrl : (config.baseUrl + '/storage/'),
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
				this.$store.dispatch('CaseTypeDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.name = item.name;
                this.editItem.price = item.price;
                this.editItem.image = null;
				this.editItem.id = null;
				this.editMode = true;
			},
			createAction: function () {
                this.errors = [];
                if (this.editItem.name == '') {
                    this.errors.push('name empty');
                }
                if (this.editItem.price == 0) {
                    this.errors.push('set price');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createCaseTypeAction', this.editItem);
                    this.editItem.name = '';
                    this.editItem.price = 0;
                    this.editItem.image = null;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('getCaseTypesListAction');
			},
			saveAction: function() {
				this.$store.dispatch('CaseTypeSaveAction', this.editItem);
                this.editItem.name = '';
                this.editItem.price = 0;
                this.editItem.image = null;
				this.editItem.id = 0;
				this.editMode = false;
			},
			createCancelAction: function() {
				this.editMode = false;
			},
            uploadImage: function(file) {
                this.editItem.image = file;
            },
    },
    computed: {
			...mapGetters([
				'checkToken',
				'CaseTypes',
			]),
    }
  }
</script>
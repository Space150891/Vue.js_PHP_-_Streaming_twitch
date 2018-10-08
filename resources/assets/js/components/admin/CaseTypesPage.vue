<template>
<div class="container">
<admin-menu page="/case-types"></admin-menu>
  <div v-if="checkToken && caseTypesLoaded">
		<h5>Case types page</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Description</th>
                    <th>Coins</th>
                    <th>Diamonds</th>
                    <th>Class</th>
                    <th>Image</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in caseTypes" :key="item.id">
					<td>{{ item.id }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.price }}</td>
                    <td>{{ item.diamonds }}</td>
                    <td>{{ item.rarity_class }}</td>
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
				<input class="form-control" placeholder="Description..." v-model="editItem.description" type="text">
                <input class="form-control" placeholder="Price..." v-model="editItem.price" type="number">
                <input class="form-control" placeholder="Diamonds..." v-model="editItem.diamonds" type="number">
                <select v-model="editItem.rarity_class_id" class="form-control">
                    <option value="0">Select ratity class</option>
                    <option v-for="rarityClass in rarityClasses" v-bind:value="rarityClass.id" :key="rarityClass.id">{{ rarityClass.name }}</option>
                </select>
                <div v-if="editMode">
				    <button @click.prevent="saveAction()" class="btn btn-success">SAVE</button>
				    <button @click.prevent="editCancelAction()" class="btn btn-default">cancel</button>
                </div>
                <button v-else @click.prevent="createAction()" class="btn btn-success">Create new</button>
			</form>
		</div>
		<modal-delete 
			v-bind:name="deletingItem.description"
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
  <div v-if="checkToken && !caseTypesLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters } from 'vuex';
  var config = require('../config/config.json');
	
  export default {
    data: () => {
      return {
			editMode: false,
			editItem: {
				description: '',
                price: 0,
                diamonds: 0,
                image: null,
                id: 0,
                rarity_class_id: 0,
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
				this.deletingItem.name = item.description;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('CaseTypeDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.description = item.description;
                this.editItem.price = item.price;
                this.editItem.diamonds = item.diamonds;
                this.editItem.image = null;
                this.editItem.id = item.id;
                this.editItem.rarity_class_id = item.rarity_class_id;
				this.editMode = true;
			},
			createAction: function () {
                this.errors = [];
                if (this.editItem.description == '') {
                    this.errors.push('description empty');
                }
                if (this.editItem.price == 0) {
                    this.errors.push('set price');
                }
                if (this.editItem.diamonds == 0) {
                    this.errors.push('set diamonds');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createCaseTypeAction', this.editItem);
                    this.editItem.description = '';
                    this.editItem.price = 0;
                    this.editItem.diamonds = 0;
                    this.editItem.image = null;
                    this.editItem.rarity_class_id = 0;
                    this.$store.commit('getCaseTypesList');
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('getCaseTypesListAction');
			},
			saveAction: function() {
				this.$store.dispatch('CaseTypeSaveAction', this.editItem);
                this.editItem.description = '';
                this.editItem.price = 0;
                this.editItem.diamonds = 0;
                this.editItem.image = null;
                this.editItem.id = 0;
                this.editItem.rarity_class_id = 0;
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
				'caseTypes',
                'caseTypesLoaded',
                'caseTypesSaved',
                'rarityClasses',
			]),
    }
  }
</script>
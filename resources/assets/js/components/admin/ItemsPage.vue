<template>
<div  >
  <admin-menu page="/items"></admin-menu>
  <div v-if="checkToken && itemsLoaded">
		<h5>Items page</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Title</th>
                    <th>Item Type</th>
                    <th>Description</th>
                    <th>Worth</th>
                    <th>Rarity class</th>
                    <th>Image</th>
                    <th>Icon</th>

					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in items" :key="item.id">
					<td>{{ item.id }}</td>
                    <td>{{ item.title }}</td>
					<td>{{ item.type }}</td>
                    <td>
                        <span v-if="item.description">{{ item.description }}</span>
                    </td>
                    <td>{{ item.worth }}</td>
                    <td>{{ item.rarity_class }}</td>
                    <td>
                        <img 
                          v-if="item.image"
                          v-bind:src="imagesUrl + item.image"
                          v-bind:style="styleImage"
                          alt="item image"/>
                    </td>
                    <td>
                        <img
                          v-if="item.icon"
                          v-bind:src="imagesUrl + item.icon"
                          v-bind:style="styleImage"
                          alt="item icon"/>
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
				<input class="form-control" placeholder="Title..." v-model="editItem.title" type="text">
                <select v-model="editItem.item_type_id" class="form-control">
                    <option value="0">Select item type</option>
                    <option v-for="itemType in itemTypes" v-bind:value="itemType.id" :key="itemType.id">{{ itemType.name }}</option>
                </select>
                <select v-model="editItem.rarity_class_id" class="form-control">
                    <option value="0">Select ratity class</option>
                    <option v-for="rarityClass in rarityClasses" v-bind:value="rarityClass.id" :key="rarityClass.id">{{ rarityClass.name }}</option>
                </select>
                <input class="form-control" placeholder="Description..." v-model="editItem.description" type="text">
                <input class="form-control" placeholder="Worth..." v-model="editItem.worth" type="number">
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
        <upload-image
          title="Icon"
          v-bind:fileName="editItem.icon"
          v-on:upload-file="uploadIcon($event)"
        >
        </upload-image>
	</div>
  <div v-if="checkToken && !itemsLoaded"  class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  var config = require('../config/config.json');
	
  export default {
    data: () => {
      return {
			editMode: false,
			editItem: {
				title: '',
                description: '',
                item_type_id: 0,
                worth : 0,
                image: null,
                icon: null,
                rarity_class_id: 0,
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
            icon: false,
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
				this.deletingItem.name = item.title;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('ItemDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.title = item.title;
                this.editItem.description = item.description ? item.description : '';
                this.editItem.worth = item.worth;
                this.editItem.item_type_id = item.item_type_id;
                this.editItem.image = null;
                this.editItem.icon = null;
                this.editItem.id = item.id;
                this.editItem.rarity_class_id = item.rarity_class_id;
				this.editMode = true;
			},
			createAction: function () {
                this.errors = [];
                if (this.editItem.title == '') {
                    this.errors.push('item title empty');
                }
                if (this.editItem.item_type_id == 0) {
                    this.errors.push('select item type id');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createItemAction', this.editItem);
                    this.editItem.title = '';
                    this.editItem.description = '';
                    this.editItem.worth = 0;
                    this.editItem.item_type_id = 0;
                    this.editItem.image = null;
                    this.editItem.icon = null;
                    this.editItem.rarity_class_id = 0;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('getItemsListAction');
			},
			saveAction: function() {
                this.errors = [];
                if (this.editItem.title == '') {
                    this.errors.push('item title empty');
                }
                if (this.editItem.item_type_id == 0) {
                    this.errors.push('select item type');
                }
                if (this.editItem.rarity_class_id == 0) {
                    this.errors.push('select rarity class');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('ItemSaveAction', this.editItem);
                    this.editItem.title = '';
                    this.editItem.description = '';
                    this.editItem.worth = 0;
                    this.editItem.item_type_id = 0;
                    this.editItem.image = null;
                    this.editItem.icon = null;
                    this.editItem.id = 0;
                    this.editMode = false;
                    this.editItem.rarity_class_id = 0;
                    this.$store.commit('getItemsList');
                } else {
                    this.openAlertModal = true;
                }

			},
			createCancelAction: function() {
				this.editMode = false;
			},
            uploadImage: function(file) {
                this.editItem.image = file;
            },
            uploadIcon: function(file) {
                this.editItem.icon = file;
            },
    },
    computed: {
			...mapGetters([
				'checkToken',
				'itemTypes',
                'items',
                'itemsLoaded',
                'itemsSaved',
                'rarityClasses',
			]),
    }
  }
</script>
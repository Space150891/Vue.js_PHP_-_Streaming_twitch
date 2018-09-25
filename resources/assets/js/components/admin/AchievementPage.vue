<template>
<div class="container">
<admin-menu page="/achievements"></admin-menu>
  <div v-if="checkToken && AchievementsLoaded">
		<h5>Achievements</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>Description</th>
                    <th>Image</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in Achievements" :key="item.id">
                    <td>{{ item.description }}</td>
                    <td>
                        <img 
                          v-if="item.image"
                          v-bind:src="imagesUrl + item.image"
                          v-bind:style="styleImage"
                          alt="achievement image"/>
                    </td>
					<td>
						<button v-if="item.image" class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
						<button v-if="!item.image" class="btn btn-xs btn-warning" @click.prevent="editAction(item)">add</button>
					</td>
				</tr>
			</tbody>
		</table>
        <div v-if="editMode">
            <upload-image
                title="upload image"
                v-bind:fileName="editItem.image"
                v-on:upload-file="uploadImage($event)"
            ></upload-image>
        </div>
		<modal-delete
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
		></modal-delete>
        <modal-alert
          AlertType="warning"
          v-bind:messages="errors"
          v-bind:opened="openAlertModal"
          v-on:close-alert-modal="openAlertModal=false"
        ></modal-alert>
	</div>
  <div v-if="checkToken && !AchievementsLoaded" class="v-loading"></div>
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
				name: '',
                price: 0,
                diamonds: 0,
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
				this.deletingItem.name = 'image for ' + item.description;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('AchievementImageDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.id = item.id;
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
                if (this.editItem.diamonds == 0) {
                    this.errors.push('set diamonds');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createCaseTypeAction', this.editItem);
                    this.editItem.name = '';
                    this.editItem.price = 0;
                    this.editItem.diamonds = 0;
                    this.editItem.image = null;
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
                this.editItem.name = '';
                this.editItem.price = 0;
                this.editItem.diamonds = 0;
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
				'caseTypes',
                'AchievementsLoaded',
                'AchievementsSaved',
			]),
    }
  }
</script>
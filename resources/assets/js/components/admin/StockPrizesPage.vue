<template>
<div class="container">
  <admin-menu page="/stock-prizes"></admin-menu>
  <div v-if="checkToken && stockPrizesLoaded">
		<h5>Stock Prizes</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>id</th>
					<th>Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Amount</th>
                    <th>Image</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in stockPrizes">
					<td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
					<td>
                        <span v-if="item.description">{{ item.description }}</span>
                    </td>
                    <td>{{ item.cost }}</td>
                    <td>{{ item.amount }}</td>
                    <td>
                        <img 
                          v-if="item.image"
                          v-bind:src="imagesUrl + item.image"
                          v-bind:style="styleImage"
                          alt="prize image"/>
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
                <input class="form-control" placeholder="Description..." v-model="editItem.description" type="text">
                <input class="form-control" placeholder="Cost..." v-model="editItem.cost" type="number">
                <input class="form-control" placeholder="Amount..." v-model="editItem.amount" type="number">
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
  <div v-if="checkToken && !stockPrizesLoaded"  class="v-loading"></div>
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
				name: '',
                description: '',
                cost: 0,
                amount : 0,
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
				this.$store.dispatch('StockPrizeDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			editAction: function (item) {
				this.editItem.name = item.name;
                this.editItem.description = item.description ? item.description : '';
                this.editItem.cost = item.cost;
                this.editItem.amount = item.amount;
                this.editItem.image = null;
				this.editItem.id = item.id;
				this.editMode = true;
			},
			createAction: function () {
                this.errors = [];
                if (this.editItem.name == '') {
                    this.errors.push('prize name empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('StockPrizeCreateAction', this.editItem);
                    this.editItem.name = '';
                    this.editItem.description = '';
                    this.editItem.worth = 0;
                    this.editItem.item_type_id = 0;
                    this.editItem.image = null;
                    this.editItem.icon = null;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('StockPrizeListAction');
			},
			saveAction: function() {
                this.errors = [];
                if (this.editItem.name == '') {
                    this.errors.push('prize name empty');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('StockPrizeUpdateAction', this.editItem);
                    this.editItem.name = '';
                    this.editItem.description = '';
                    this.editItem.cost = 0;
                    this.editItem.amount = 0;
                    this.editItem.image = null;
                    this.editItem.id = 0;
                    this.editMode = false;
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
    },
    computed: {
			...mapGetters([
				'checkToken',
                'stockPrizes',
                'stockPrizesLoaded',
                'stockPrizesSaved',
			]),
    }
  }
</script>
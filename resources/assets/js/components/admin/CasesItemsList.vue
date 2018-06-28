<template>
<div class="container">
  <div v-if="checkToken">
		<h5>Case <strong>{{ LootCase.name }}</strong></h5>
		<table class="table table-striped">
		  <thead>
				<tr>
					<th>Title</th>
                    <th>Icon</th>
                    <th>Type</th>
                    <th>Rarity</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in caseItems">
                    <td>{{ item.title }}</td>
                    <td>
                        <img 
                          v-if="item.icon"
                          v-bind:src="imagesUrl + item.icon"
                          v-bind:style="styleImage"
                          alt="item icon"/>
                    </td>
					<td>{{ item.type }}</td>
                    <td>{{ item.rarity }}</td>
					<td>
						<button class="btn btn-xs btn-danger" @click.prevent="confirmDeleteAction(item)">del</button>
					</td>
				</tr>
			</tbody>
		</table>
		<div>
            <form class="form form-inline">
                <select v-model="newItem.item_id" class="form-control">
                    <option value="0">Select item</option>
                    <option v-for="item in items" v-bind:value="item.id">{{ item.title + ' ' + item.type + ' ' + item.worth }}</option>
                </select>
                <select v-model="newItem.rarity_id" class="form-control">
                    <option value="0">Select rarity</option>
                    <option v-for="rarity in rarities" v-bind:value="rarity.id">{{ rarity.name + ' ' + rarity.percent + '%' }}</option>
                </select>
                <button @click.prevent="createAction()" class="btn btn-success">Add</button>
			</form>
		</div>
        <div>
            <button v-on:click="$emit('close-items-list')"  class="btn btn-success">DONE</button>
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
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  var config = require('../admin/config.json');
	
  export default {
    // props: ['LootCase'],
    props: {
        LootCase : {
            type: Object,
            required: true,
        },
    },
    data() {
      return {
			newItem: {
                item_id: 0,
                rarity_id: 0,
				id: 0,
                case_id: this.LootCase.id,
			},
			deletingItem: {
				name: '',
				id: 0,
				openModal: false,
			},
            errors: [],
            openAlertModal: false,
            imagesUrl : (config.baseUrl + '/storage/'),
            styleImage: {
                width: "100px",
                border: "1px #888 solid",
                borderRadius: "2px",
            },
        }
    },
		mounted() {
			if (this.checkToken) {
				this.getList();
			}
		},
    methods: {
			confirmDeleteAction: function (item) {
				this.deletingItem.name = item.title + ' ' + item.rarity;
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
				this.$store.dispatch('CaseItemDeleteAction', this.deletingItem.id);
				this.deletingItem.openModal = false;
			},
			createAction: function () {
                this.errors = [];
                if (this.newItem.item_id == 0) {
                    this.errors.push('select item');
                }
                if (this.newItem.rarity_id == 0) {
                    this.errors.push('select rarity');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('CaseItemCreateAction', this.newItem);
                    this.newItem.rarity_id = 0;
                    this.newItem.item_id = 0;
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('CaseItemsListAction', this.LootCase.id);
			},
    },
    computed: {
			...mapGetters([
				'checkToken',
				'caseTypes',
                'items',
                'rarities',
                'caseItems',
			]),
    }
  }
</script>
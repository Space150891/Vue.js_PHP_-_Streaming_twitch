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
                    <th>WIN</th>
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
                    <td>
                        <p>
                            Hero
                            <span class="badge badge-primary">{{ getRarityById(item.hero_rarity_id) }}</span>
                            <span class="badge badge-warning">{{ item.hero_percent }} %</span>
                        </p>
                        <p>
                            Frame
                            <span class="badge badge-primary">{{ getRarityById(item.frame_rarity_id) }}</span>
                            <span class="badge badge-warning">{{ item.frame_percent }} %</span>
                        </p>
                        <p>
                            Prize
                            <span class="badge badge-primary">{{ item.prize_cost }} $</span>
                            <span class="badge badge-warning">{{ item.prize_percent }} %</span>
                        </p>
                        <p>
                            Points
                            <span class="badge badge-primary">{{ item.points_count }} pcs.</span>
                            <span class="badge badge-warning">{{ item.points_percent }} %</span>
                        </p>
                        <p>
                            Diamonds
                            <span class="badge badge-primary">{{ item.diamonds_count }} pcs.</span>
                            <span class="badge badge-warning">{{ item.diamonds_percent }} %</span>
                        </p>
                        <p>
                            win nothing
                            <span class="badge badge-warning">{{ 100 - item.hero_percent - item.frame_percent - item.prize_percent - item.points_percent - item.diamonds_percent }}</span>
                        </p>
                    </td>
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
            <form>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-description">Description</label>
                    </div>
				    <input class="form-control" placeholder="Description..." v-model="editItem.description" type="text" id="edit-description">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-price">Box cost (points)</label>
                    </div>
                    <input class="form-control" placeholder="Price..." v-model="editItem.price" type="number" id="edit-price">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-diamonds">Box cost (diamonds)</label>
                    </div>
                    <input class="form-control" placeholder="Diamonds..." v-model="editItem.diamonds" type="number" id="edit-diamonds">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-rarity-class">Box Rarity class</label>
                    </div>
                    <select v-model="editItem.rarity_class_id" class="form-control" id="edit-rarity-class">
                        <option value="0">Select ratity class</option>
                        <option v-for="rarityClass in rarityClasses" v-bind:value="rarityClass.id" :key="rarityClass.id">{{ rarityClass.name }}</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-hero-rarity">WIN Hero rarity</label>
                    </div>
                    <select v-model="editItem.hero_rarity_id" class="form-control" id="edit-hero-rarity">
                        <option value="0">No</option>
                        <option v-for="rarityClass in rarityClasses" v-bind:value="rarityClass.id" :key="rarityClass.id">{{ rarityClass.name }}</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-frame-rarity">WIN Frame rarity</label>
                    </div>
                    <select v-model="editItem.frame_rarity_id" class="form-control" id="edit-frame-rarity">
                        <option value="0">No</option>
                        <option v-for="rarityClass in rarityClasses" v-bind:value="rarityClass.id" :key="rarityClass.id">{{ rarityClass.name }}</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-prize-cost">WIN Prize $</label>
                    </div>
                    <input class="form-control" placeholder="Prize cost..." v-model="editItem.prize_cost" type="number" id="edit-prize-cost">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-points-count">WIN Points count</label>
                    </div>
                    <input class="form-control" placeholder="Points count..." v-model="editItem.points_count" type="number" id="edit-points-count" min=0>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-diamonds-count">WIN Diamonds count</label>
                    </div>
                    <input class="form-control" placeholder="Points count..." v-model="editItem.diamonds_count" type="number" id="edit-diamonds-count" min=0>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-hero-percent">WIN Hero %</label>
                    </div>
                    <input class="form-control" v-model="editItem.hero_percent" type="number" id="edit-hero-percent" min=0 max=99>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-frame-percent">WIN Frame %</label>
                    </div>
                    <input class="form-control" v-model="editItem.frame_percent" type="number" id="edit-frame-percent" min=0 max=99>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-prize-percent">WIN Prize %</label>
                    </div>
                    <input class="form-control" v-model="editItem.prize_percent" type="number" id="edit-prize-percent" min=0 max=99>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-points-percent">WIN Points %</label>
                    </div>
                    <input class="form-control" v-model="editItem.points_percent" type="number" id="edit-points-percent" min=0 max=99>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-diamonds-percent">WIN Diamonds %</label>
                    </div>
                    <input class="form-control" v-model="editItem.diamonds_percent" type="number" id="edit-diamonds-percent" min=0 max=99>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="edit-diamonds-percent">WIN nothing %</label>
                    </div>
                    <div class="form-control">
                        {{calculateZero}} %
                    </div>
                </div>

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
                hero_rarity_id:0,
                frame_rarity_id:0,
                prize_cost:0,
                points_count:0,
                diamonds_count:0,
                hero_percent:0,
                frame_percent:0,
                prize_percent:0,
                points_percent:0,
                diamonds_percent:0,
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
                this.editItem.hero_rarity_id = item.hero_rarity_id;
                this.editItem.frame_rarity_id = item.frame_rarity_id;
                this.editItem.prize_cost = item.prize_cost;
                this.editItem.points_count = item.points_count;
                this.editItem.diamonds_count = item.diamonds_count;
                this.editItem.hero_percent = item.hero_percent;
                this.editItem.frame_percent = item.frame_percent;
                this.editItem.prize_percent = item.prize_percent;
                this.editItem.points_percent = item.points_percent;
                this.editItem.diamonds_percent = item.diamonds_percent;
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
                if (this.editItem.prize_cost < 0) {
                    this.errors.push('wrong prize cost');
                }
                if (this.editItem.prize_cost < 0) {
                    this.errors.push('wrong prize cost');
                }
                if (this.editItem.points_count < 0) {
                    this.errors.push('wrong points count');
                }
                if (this.editItem.diamonds_count < 0) {
                    this.errors.push('wrong diamonds count');
                }
                if (this.editItem.hero_percent < 0 || this.editItem.hero_percent > 99) {
                    this.errors.push('wrong hero percent');
                }
                if (this.editItem.frame_percent < 0 || this.editItem.frame_percent > 99) {
                    this.errors.push('wrong frame percent');
                }
                if (this.editItem.prize_percent < 0 || this.editItem.prize_percent > 99) {
                    this.errors.push('wrong prize percent');
                }
                if (this.editItem.points_percent < 0 || this.editItem.points_percent > 99) {
                    this.errors.push('wrong points percent');
                }
                if (this.editItem.diamonds_percent < 0 || this.editItem.diamonds_percent > 99) {
                    this.errors.push('wrong diamonds percent');
                }
                if (this.calculateZero < 0 || this.calculateZero > 100) {
                    this.errors.push('wrong total percents`s sum');
                }
                if (this.errors.length == 0) {
                    this.$store.dispatch('createCaseTypeAction', this.editItem);
                    this.$store.commit('getCaseTypesList');
                    this.editCancelAction();
                } else {
                    this.openAlertModal = true;
                }
			},
			getList: function () {
                this.$store.dispatch('getCaseTypesListAction');
			},
			saveAction: function() {
				this.$store.dispatch('CaseTypeSaveAction', this.editItem);
                this.editCancelAction();
			},
			editCancelAction: function() {
                this.editItem.description = '';
                this.editItem.price = 0;
                this.editItem.diamonds = 0;
                this.editItem.image = null;
                this.editItem.id = 0;
                this.editItem.rarity_class_id = 0;
                this.editItem.hero_rarity_id = 0;
                this.editItem.frame_rarity_id = 0;
                this.editItem.prize_cost = 0;
                this.editItem.points_count = 0;
                this.editItem.diamonds_count = 0;
                this.editItem.hero_percent = 0;
                this.editItem.frame_percent = 0;
                this.editItem.prize_percent = 0;
                this.editItem.points_percent = 0;
                this.editItem.diamonds_percent = 0;
				this.editMode = false;
			},
            uploadImage: function(file) {
                this.editItem.image = file;
            },
            getRarityById: function(rarityId) {
                let rarity = 'NO';
                for (let index = 0; index < this.rarityClasses.length; index++) {
                    const rarityClass = this.rarityClasses[index];
                    if (this.rarityClasses[index].id == rarityId) {
                        rarity = this.rarityClasses[index].name;
                    }
                }
                return rarity;
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
        calculateZero: function () {
            return 100 - this.editItem.hero_percent - this.editItem.frame_percent - this.editItem.prize_percent - this.editItem.points_percent - this.editItem.diamonds_percent;
        },
    }
  }
</script>
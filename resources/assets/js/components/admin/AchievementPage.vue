<template>
<div class="container">
<admin-menu page="/achievements"></admin-menu>
  <div v-if="checkToken && AchievementsLoaded">
		<h5>Achievements</h5>
		<table class="table table-striped">
		  <thead>
				<tr>
                    <th>Name</th>
					<th>Description</th>
                    <th>Steps</th>
                    <th>Points</th>
                    <th>Diamonds</th>
                    <th>Case</th>
                    <th>Card</th>
                    <th>Frame</th>
                    <th>Hero</th>
                    <th>Image</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in Achievements" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.steps }}</td>
                    <td>{{ item.level_points }}</td>
                    <td>{{ item.diamonds }}</td>
                    <td>{{ item.case }}</td>
                    <td>{{ item.card }}</td>
                    <td>{{ item.frame }}</td>
                    <td>{{ item.hero }}</td>
                    <td>
                        <img 
                          v-if="item.image"
                          v-bind:src="imagesUrl + item.image"
                          v-bind:style="styleImage"
                          alt="achievement image"/>
                    </td>
					<td>
						<button class="btn btn-xs btn-warning" @click.prevent="editAction(item)">edit</button>
					</td>
				</tr>
			</tbody>
		</table>
        <div v-if="editMode" class="edit-modal">
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Name</span>
                    </div>
                    <input v-model="editItem.name" type="text" class="form-control" placeholder="Name..">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Description</span>
                    </div>
                    <textarea class="form-control" v-model="editItem.description">
                    </textarea>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Steps</span>
                    </div>
                    <input v-model="editItem.steps" type="number" class="form-control" placeholder="Steps.."/>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Diamonds</span>
                    </div>
                    <input v-model="editItem.diamonds" type="number" class="form-control" placeholder="Diamonds.."/>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Points</span>
                    </div>
                    <input v-model="editItem.level_points" type="number" class="form-control" placeholder="Points.."/>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Case</span>
                    </div>
                    <select v-model="editItem.case_rarity_id" class="form-control">
                        <option value="0">no</option>
                        <option v-for="rClass in rarityClasses" :key="rClass.id" v-bind:value="rClass.id">{{ rClass.name }}</option>
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Card</span>
                    </div>
                    <select v-model="editItem.card_rarity_id" class="form-control">
                        <option value="0">no</option>
                        <option v-for="rClass in rarityClasses" :key="rClass.id" v-bind:value="rClass.id">{{ rClass.name }}</option>
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Frame</span>
                    </div>
                    <select v-model="editItem.frame_rarity_id" class="form-control">
                        <option value="0">no</option>
                        <option v-for="rClass in rarityClasses" :key="rClass.id" v-bind:value="rClass.id">{{ rClass.name }}</option>
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Hero</span>
                    </div>
                    <select v-model="editItem.hero_rarity_id" class="form-control">
                        <option value="0">no</option>
                        <option v-for="rClass in rarityClasses" :key="rClass.id" v-bind:value="rClass.id">{{ rClass.name }}</option>
                    </select>
                </div>
                <upload-image
                    title="achievement image"
                    v-bind:fileName="editItem.image"
                    v-on:upload-file="uploadImage($event)"
                ></upload-image>
                <div>
                    <button class="btn btn-success pull-left" @click.prevent="saveAction()">SAVE</button>
                    <button class="btn btn-warning pull-right" @click.prevent="cancelAction()">Close</button>
                </div>
            </div>
        </div>
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
<style>
.edit-modal {
    position: fixed; top:0; left:0; width:100%; height: 100%; background: rgb(1,1,1, .5);
    border-radius: 0;
}
.edit-modal > div {
    position:absolute;  left:50%; top:100px; margin-left:-200px; width:400px; background:#fff;  padding:15px;  border-radius:10px;
}
</style>

<script>
  import { mapGetters } from 'vuex';
  var config = require('../config/config.json');
	
  export default {
    data: () => {
      return {
			editMode: false,
			editItem: {
                name: '',
                description: '',
                steps: 0,
                level_points: 0,
                diamonds: 0,
                case_rarity_id: 0,
                card_rarity_id: 0,
                frame_rarity_id: 0,
                hero_rarity_id: 0,
                image: null,
				id: 0,
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
        editAction: function (item) {
            this.editItem.id = item.id;
            this.editItem.name = item.name;
            this.editItem.description = item.description;
            this.editItem.steps = item.steps;
            this.editItem.level_points = item.level_points;
            this.editItem.diamonds = item.diamonds;
            this.editItem.case_rarity_id = item.case_rarity_id;
            this.editItem.card_rarity_id = item.card_rarity_id;
            this.editItem.frame_rarity_id = item.frame_rarity_id;
            this.editItem.hero_rarity_id = item.hero_rarity_id;
            this.editMode = true;
        },
        getList: function () {
            // this.$store.dispatch('getCaseTypesListAction');
            this.$store.dispatch('getAchievements');
        },
        saveAction: function() {
            this.$store.dispatch('achievementSaveAction', this.editItem);
            this.clear();
            this.editMode = false;
        },
        cancelAction: function() {
            this.clear();
            this.editMode = false;
        },
        clear: function() {
            this.editItem.id = 0;
            this.editItem.name = '';
            this.editItem.description = '';
            this.editItem.steps = 0;
            this.editItem.level_points = 0;
            this.editItem.diamonds = 0;
            this.editItem.case_rarity_id = 0;
            this.editItem.card_rarity_id = 0;
            this.editItem.frame_rarity_id = 0;
            this.editItem.hero_rarity_id = 0;
        },
        uploadImage: function(file) {
            this.editItem.image = file;
        },
    },
    computed: {
        ...mapGetters([
            'checkToken',
            'rarityClasses',
            'Achievements',
            'AchievementsLoaded',
            'AchievementsSaved',
        ]),
    }
  }
</script>
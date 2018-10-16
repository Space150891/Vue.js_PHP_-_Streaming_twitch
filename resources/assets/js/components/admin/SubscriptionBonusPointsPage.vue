<template>
<div  >
  <admin-menu page="/bonus-points"></admin-menu>
  <div v-if="checkToken && subscriptionPlansLoaded">
    <h2>Subscription bonus points</h2>
    <div class="row">
      <div v-if="subscriptionPlansLoaded" class="col-md-3">
        <h5>Subscription plans</h5>
        <ul class="list-group">
          <li 
          v-for="plan in subscriptionPlans" :key="plan.id"
          @click="selectPlan(plan)"
          v-bind:class="{'list-group-item': true, 'active' : plan.id == selectedPlan}" 
          >{{ plan.name }}</li>
        </ul>
      </div>
      <div v-if="!subscriptionPlansLoaded" class="col-md-3 v-loading">
      </div>
      <div v-if="selectedPlan > 0 && subscriptionBonusPointsLoaded" class="col-md-9">
        <table class="table table-striped">
          <thead>
            <tr>
              <th> from </th>
              <th> to </th>
              <th> points </th>
              <th> actions </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="scheme in subscriptionBonusPoints" :key="scheme.id">
              <td>
                {{ scheme.from_viewers }}
              </td>
              <td>
                {{ scheme.to_viewers }}
              </td>
              <td>
                {{ scheme.points }}
              </td>
              <td>
                <button @click.prevent="editAction(scheme)" class="btn btn-sm btn-warning">edit</button>
                <button @click.prevent="confirmDeleteAction(scheme)" class="btn btn-sm btn-danger">delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div>
            <form class="form form-inline">
              <input class="form-control" placeholder="From..." v-model="editItem.from_viewers" type="number">
              <input class="form-control" placeholder="To..." v-model="editItem.to_viewers" type="number">
              <input class="form-control" placeholder="Points..." v-model="editItem.points" type="number">
              <div v-if="editMode">
                <button @click.prevent="saveAction()" class="btn btn-success">UPDATE</button>
                <button @click.prevent="cancelAction()" class="btn btn-default">cancel</button>
              </div>
              <button v-else @click.prevent="createAction()" class="btn btn-success">Create new</button>
          </form>
        </div>
        <div>
          <form class="form form-inline">
              base points:
              <input class="form-control" placeholder="base..." v-model="selectedPlanPoints" type="number">
              <button @click.prevent="saveBasePoints()" class="btn btn-success">SAVE BASE</button>
          </form>
        </div>
      </div>
      <div v-if="selectedPlan == 0" class="col-md-9">
        select subscription plan
      </div>
      <div v-if="selectedPlan > 0 && !subscriptionBonusPointsLoaded" class="col-md-9 v-loading">
        
      </div>
      <modal-delete 
			v-bind:name="deletingItem.name"
			v-bind:opened="deletingItem.openModal"
			v-on:close-delete-modal="deletingItem.openModal=false"
			v-on:confirm-delete="deleteAction"
			></modal-delete>
    </div>
  </div>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  var config = require('../config/config.json');
	
  export default {
    data: () => {
      return {
        selectedPlan : 0,
        selectedPlanPoints : 0,
        editMode: false,
        editItem: {
          from_viewers: 0,
          to_viewers: 0,
          points : 0,
          id: 0,
          subscription_point_id: 0,
        },
        deletingItem: {
          name: '',
          id: 0,
          openModal: false,
        },
      }
    },	
		mounted() {
			if (this.checkToken) {
        this.$store.commit('getSubscriptionPlansList');
			}
		},
    methods: {
			selectPlan: function (plan) {
        this.selectedPlan = plan.id;
        this.selectedPlanPoints = plan.points;
        this.$store.commit('loadSubscriptionBonusPoints', plan.id);
      },
      editScheme: function (scheme) {
      },
      confirmDeleteAction: function (item) {
				this.deletingItem.name = '';
				this.deletingItem.id = item.id;
				this.deletingItem.openModal = true;
			},
			deleteAction: function () {
        const data = {
          deleteId  : this.deletingItem.id,
          selectedPlan: this.selectedPlan,
        }
				this.$store.dispatch('deleteSubscriptionBonusPointsAction', data);
				this.deletingItem.openModal = false;
      },
      editAction: function (item) {
				this.editItem.from_viewers = item.from_viewers;
        this.editItem.to_viewers = item.to_viewers;
        this.editItem.points = item.points;
        this.editItem.id = item.id;
        console.log('in edit id=', item.id);
				this.editMode = true;
			},
			createAction: function () {
        let data = this.editItem;
        data.selectedPlan = this.selectedPlan;
        this.$store.dispatch('createSubscriptionBonusPointsAction', data);
        this.editItem.points = 0;
        this.editItem.from_viewers = 0;
        this.editItem.to_viewers = 0;
        this.editItem.id = 0;
        this.editItem.subscription_plan_id = 0;
      },
      cancelAction: function() {
        this.editItem.points = 0;
        this.editItem.from_viewers = 0;
        this.editItem.to_viewers = 0;
        this.editItem.id = 0;
				this.editMode = false;
      },
      saveAction: function() {
        let data = this.editItem;
        data.selectedPlan = this.selectedPlan;
        this.$store.dispatch('updateSubscriptionBonusPointsAction', data);
        this.editItem.points = 0;
        this.editItem.from_viewers = 0;
        this.editItem.to_viewers = 0;
        this.editItem.id = 0;
        this.editItem.subscription_plan_id = 0;
				this.editMode = false;
      },
      saveBasePoints: function() {
        const data = {
          points: this.selectedPlanPoints,
          id: this.selectedPlan
        };
        this.$store.dispatch('updateSubscriptionPointsAction', data);
      },
    },
    computed: {
			...mapGetters([
				'checkToken',
				'subscriptionPlans',
        'subscriptionPlansLoaded',
        'subscriptionBonusPoints',
        'subscriptionBonusPointsLoaded',
			]),
    }
  }
</script>
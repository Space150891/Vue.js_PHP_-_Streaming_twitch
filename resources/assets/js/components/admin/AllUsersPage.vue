<template>
<div class="container">
  <admin-menu page="/users"></admin-menu>
  <div v-if="checkToken && usersLoaded">
		<h5>All Users</h5>
		<table class="table table-striped table-condenced">
		  <thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
                    <th>Twitch id</th>
                    <th>Followers</th>
					<th>Points</th>
                    <th>Diamonds</th>
                    <th>Level</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in users">
                    <td>{{item.name}}</td>
					<td>{{item.email}}</td>
                    <td>{{item.twitch_id}}</td>
                    <td>{{item.followers}}</td>
                    <td>{{item.level_points}}</td>
                    <td>{{item.diamonds}}</td>
                    <td>{{item.level}}</td>
					<td>
						<button 
						  class="btn btn-xs btn-info"
						  @click.prevent="viewMore(item.id)"
						  >
						  	more
						</button>
					</td>
				</tr>
			</tbody>
		</table>
		<pagination
		  v-bind:page="page"
		  v-bind:pages="usersPages"
		  buttons="5"
		  v-on:load-page="loadPage($event)"
		>
		</pagination>
        <div v-if="modalView" class="edit-modal-back">
            <div class="edit-modal">
                <h3>{{ editUser.name }}</h3>
                <div v-if="editUser.subscriptions.length > 0">
                    <h5>existing subscriptions:</h5>
                    <ul class="list-group">
                        <li
                            v-for="s in editUser.subscriptions"
                            class="list-group-item disabled"
                        >
                            <strong>{{s.subscription}}</strong>
                            <span class="badge badge-secondary">
                                {{s.month}} monthes
                            </span>
                            {{s.valid_from.substring(0, 10)}} - {{s.valid_until.substring(0, 10)}}
                        </li>
                    </ul>
                </div>
                <h5>create:</h5>
                <select v-model="form.subscriptionPlan" class="form-control" name="subscription_plan_id">
                    <option value=0>Select subscription plan</option>
                    <option v-for="subscriptionPlan in subscriptionPlans" v-bind:value="subscriptionPlan.id">
                        {{subscriptionPlan.name}} cost {{subscriptionPlan.price}}
                    </option>
                </select>
                <select  v-model="form.monthPlan" class="form-control" name="month_plan_id">
                    <option value=0>Select months</option>
                    <option v-for="monthPlan in monthPlans" v-bind:value="monthPlan.id">
                        months {{monthPlan.monthes}} discount {{monthPlan.percent}} %
                    </option>
                </select>
                <input type="hidden" v-bind:value="editUser.id" name="streamer_id">
                <button type="submit" class="btn btn-success form-control" @click.prevent="submitSubscribe()"> SUBSCRIBE </button>
                <button type="submit" class="btn btn-warning form-control" @click.prevent="cancel()"> close </button>
            </div>
        </div>
        <modal-alert
          AlertType="notify"
          v-bind:messages="['user subscribed']"
          v-bind:opened="openAlertModal"
          v-on:close-alert-modal="openAlertModal=false"
        >
        </modal-alert>
	</div>
  <div v-if="checkToken && !usersLoaded" class="v-loading"></div>
  <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  let config = require('../config/config.json');

  export default {
    data: () => {
      return {
			errors: [],
            page: 1,
            onPage: config.on_page,
            modalView : false,
            openAlertModal : false,
            form: {
                subscriptionPlan: 0,
                monthPlan: 0,
                userId : 0,
            },
        }
    },
	mounted() {
		if (this.checkToken) {
			this.getList();
            this.$store.dispatch('getSubscribeData');
		}
	},
    methods: {
		getList: function () {
			this.$store.commit('getPaggUsersList', {
				page: this.page,
				onPage: this.onPage
			});
		},
		viewMore: function (id) {
            this.modalView = true;
            console.log('viewing user ', id);
            this.$store.commit('getEditUser', id);
		},
		loadPage: function (pageNumber) {
			this.page = pageNumber;
			this.getList();
		},
        submitSubscribe: function () {
            if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
                this.form.userId = this.editUser.id;
                this.$store.commit('subscribeUser', this.form);
                this.modalView = false;
                this.openAlertModal = true;
                this.form.subscriptionPlan = 0;
                this.form.monthPlan = 0;
            }
        },
        cancel: function () {
            this.modalView = false;
        },
    },
    computed: {
		...mapGetters([
			'checkToken',
			'users',
			'usersPages',
			'usersLoaded',
            'subscriptionPlans',
            'monthPlans',
            'editUser',
		]),
    }
  }
</script>
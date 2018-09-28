<template>
<div class="container">
  <admin-menu page="/subscriptions"></admin-menu>
  <div v-if="checkToken && subscriptions.loaded">
		<h5>Subscriptions</h5>
        <div>
            <select @change="getList()" v-model="period" class="form-control">
                <option>day</option>
                <option>week</option>
                <option>month</option>
                <option>year</option>
                <option>all</option>
            </select>
        </div>
		<table class="table table-striped table-condenced">
		  <thead>
				<tr>
					<th>User</th>
					<th>Subscription plan</th>
					<th>Started at</th>
					<th>Valid until</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in subscriptions.list" :key="item.id">
					<td>{{item.name}}</td>
					<td>{{item.plan}}</td>
					<td>{{item.valid_from.substr(0, 10)}}</td>
					<td>{{item.valid_until.substr(0, 10)}}</td>
				</tr>
			</tbody>
		</table>
		<pagination
		  v-bind:page="page"
		  v-bind:pages="subscriptions.pages"
		  buttons="5"
		  v-on:load-page="loadPage($event)"
		>
		</pagination>
	</div>
  <div v-if="checkToken && !subscriptions.loaded" class="v-loading"></div>
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
            period: 'all',
        }
    },
	mounted() {
		if (this.checkToken) {
			this.getList();
		}
	},
    methods: {
		getList: function () {
			this.$store.commit('getPaggSubscribeList', {
				page: this.page,
				onPage: this.onPage,
				period: this.period,
			});
		},
		loadPage: function (pageNumber) {
			this.page = pageNumber;
			this.getList();
		},
    },
    computed: {
		...mapGetters([
			'checkToken',
			'subscriptions',
		]),
    }
  }
</script>
<template>
<div class="container">
    <admin-menu page="/statistic"></admin-menu>
    <div v-if="checkToken">
        <ul class="nav nav-tabs">
            <li class="nav-item" v-for="tableName in tables" :key="tableName">
                <a v-if="tableName == filter.table" class="nav-link active" href="#">{{ tableName }}</a>
                <a v-else @click.prevent="selectTable(tableName)" class="nav-link" href="#">{{ tableName }}</a>
            </li>
        </ul>
    </div>
    <div v-if="checkToken && filter.table != ''">
		<div>
            <strong>Show:</strong>
            <label class="form-group">
                period:
                <select v-model="filter.period" v-on:change="loadTable()" class="form-control">
                    <option v-for="period in periods" :key="period">{{period}}</option>
                </select>
            </label>
        </div>
		<table v-if="statistic.loaded" class="table table-striped table-condenced">
		    <thead>
				<tr>
					<th v-for="field in statistic.fields" :key="field">
                        {{field}}
                    </th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item in statistic.values" :key="item.id">
                    <td v-for="field in statistic.fields" :key="field">
                        {{item[field]}}
                    </td>
                </tr>
			</tbody>
		</table>
		<pagination
            v-if="statistic.loaded"
		    v-bind:page="statistic.page"
		    v-bind:pages="statistic.pages"
		    buttons="3"
		    v-on:load-page="getPage($event)"
		>
		</pagination>
        <div v-if="checkToken && statistic.loaded == false" class="v-loading"></div>
	</div>
    <div v-if="checkToken && filter.table == ''">
        <h5>select table</h5>
    </div>
    <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
  import { mapGetters} from 'vuex';
  let config = require('../config/config.json');

  export default {
    data: () => {
      return {
            filter: {
                page: 0,
                on_page: 10,
                period: 'all',
                table: '',
            },
            periods: ['all', 'year', 'month', 'day'],
            tables: ['payments', 'winned prizes'],
        }
    },
	mounted() {

	},
    methods: {
        getPage: function(page) {
            this.filter.page = page;
            this.loadTable();
        },
		loadTable: function () {
            console.log('coading table');
			this.$store.dispatch('loadStatisticAction', this.filter);
		},
        selectTable: function (tableName) {
            this.filter.table = tableName;
            this.filter.page = 1;
            console.log('change table');
            this.loadTable();
        },
    },
    computed: {
		...mapGetters([
			'checkToken',
			'statistic',
		]),
    }
  }
</script>
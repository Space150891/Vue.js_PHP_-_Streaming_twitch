<template>
    <div v-if="checkToken" class="cabinet-page" >
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Subscription</h5>
                <form action="paypal/pay" method="POST">
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
                    <input type="hidden" v-bind:value="currentStreamer.id" name="streamer_id">
                    <button type="submit" class="btn btn-success form-control" @click="submitAction"> SUBSCRIBE </button>
                </form>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        data(){
            return {
                form : {
                    subscriptionPlan : 0,
                    monthPlan : 0,
                }
            }
        },
        mounted() {
            this.$store.dispatch('getSubscribeData');
        },
        methods: {
            submitAction(event) {
                if (this.form.subscriptionPlan == 0 || this.form.monthPlan == 0) {
                    event.preventDefault();
                }
            },
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            currentStreamer: function () {
                return this.$store.getters.currentStreamer;
            },
            subscriptionPlans: function () {
                return this.$store.getters.subscriptionPlans;
            },
            monthPlans: function () {
                return this.$store.getters.monthPlans;
            },
        },
    }
</script>
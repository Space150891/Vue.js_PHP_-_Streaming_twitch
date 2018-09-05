<template>
    <div v-if="checkToken" class="cabinet-page" >
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Subscription</h5>
                <form action="paypal/pay" method="POST">
                    <select v-model="form.subscriptionPlan" class="form-control" name="subscription_plan_id">
                        <option value=0>Select subscription plan</option>
                        <option v-for="subscriptionPlan in subscriptionPlans" v-bind:value="subscriptionPlan.id" :key="subscriptionPlan.id">
                            {{subscriptionPlan.name}} cost {{subscriptionPlan.price}}
                        </option>
                    </select>
                    <select v-on:change="loadLiqForm()" v-model="form.monthPlan" class="form-control" name="month_plan_id">
                        <option value=0>Select months</option>
                        <option v-for="monthPlan in monthPlans" v-bind:value="monthPlan.id" :key="monthPlan.id">>
                            months {{monthPlan.monthes}} discount {{monthPlan.percent}} %
                        </option>
                    </select>
                    <input type="hidden" v-bind:value="currentStreamer.user_id" name="user_id">
                    <input type="hidden" value="subscription" name="type">
                    <div v-if="!payReady" class="pay-disable">
                        <img src="\images\paypal_bw.png" alt="paypal icon">
                        <img src="\images\liqpay_bw.png" alt="liqpay icon">
                        <img src="\images\qiwi_bw.png" alt="qiwi icon">
                    </div>
                    <div v-if="payReady" class="pay-enable">
                        <div>
                            <img @click="submitAction" src="\images\paypal.png" alt="paypal icon">
                        </div>
                        <div>
                            <img src="\images\liqpay.png" alt="liqpay icon">
                            {{ payments.liqForm }}
                        </div>
                        <div>
                            <img src="\images\qiwi.png" alt="qiwi icon">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<style>
.pay-disable {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

.pay-disable > img{
    width: 100px;
}

.pay-enable {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

.pay-enable>div {
    width: 100px;
}

.pay-enable>div img {
    cursor: pointer;
    width: 100%;
} 

</style>
<script>
    export default {
        data(){
            return {
                form : {
                    subscriptionPlan : 0,
                    monthPlan : 0,
                },
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
            loadLiqForm() {
                if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
                    const data = {
                        subscriptionPlan,
                        monthPlan,
                    };
                    this.$store.dispatch('getLiqFormAction', data);
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
            payReady: function () {
                if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
                    return true;
                } else {
                    return false;
                }
            },
            payments: function () {
                return this.$store.getters.payments;
            }
        },
    }
</script>
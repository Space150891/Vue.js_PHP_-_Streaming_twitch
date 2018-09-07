<template>
    <div v-if="checkToken" class="cabinet-page" >
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Subscription</h4>
                <form action="paypal/pay" method="POST" class="paypal-form">
                    <div class="form-group">
                        <label for="subscriptionPlan">Select subscription plan:</label>
                        <select v-on:change="loadLiqForm()"
                                v-model="form.subscriptionPlan"
                                class="form-control"
                                name="subscription_plan_id"
                                id="subscriptionPlan">
                            <option value=0 selected disabled>Select subscription plan</option>
                            <option v-for="subscriptionPlan in subscriptionPlans" v-bind:value="subscriptionPlan.id" :key="subscriptionPlan.id">
                                {{subscriptionPlan.name}} cost {{subscriptionPlan.price}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monthPlan">Select month plan:</label>
                        <select v-on:change="loadLiqForm()"
                                v-model="form.monthPlan"
                                class="form-control"
                                name="month_plan_id"
                                id="monthPlan">
                            <option value=0 selected disabled>Select months</option>
                            <option v-for="monthPlan in monthPlans" v-bind:value="monthPlan.id" :key="monthPlan.id">>
                                months {{monthPlan.monthes}} discount {{monthPlan.percent}} %
                            </option>
                        </select>
                    </div>
                    <input type="hidden" v-bind:value="currentStreamer.user_id" name="user_id">
                    <input type="hidden" value="subscription" name="type">
                    <div v-if="!payReady" class="pay-disable row">
                        <div class="col-md-3">
                            <img src="\images\paypal.png" alt="paypal icon">
                        </div>
                        <div class="col-md-3">
                            <img src="\images\liqpay.png" alt="liqpay icon">
                        </div>
                        <div class="col-md-3">
                            <img src="\images\yandex.png" alt="yandex icon">
                        </div>
                        <div class="col-md-3">
                            <img src="\images\stripe.png" alt="stripe icon">
                        </div>
                    </div>
                </form>
                <div v-if="payReady" class="pay-enable row">
                    <div class="col-md-3">
                        <img @click="submitAction" src="\images\paypal.png" alt="paypal icon">
                    </div>
                    <div class="col-md-3">
                        <img @click="loadLiqForm" src="\images\liqpay.png" alt="liqpay icon">
                        <div v-html="payments"></div>
                    </div>
                    <div class="col-md-3">
                        <img src="\images\yandex.png" alt="yandex icon">
                    </div>
                    <div class="col-md-3">
                        <img src="\images\stripe.png" alt="stripe icon">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<style>
    .pay-disable div{
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .pay-disable img{
        width: 100px;
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    }

    .pay-enable div{
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .pay-enable div img {
        cursor: pointer;
        width: 100px;
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
      submitAction() {
        if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
          document.getElementsByClassName('paypal-form')[0].submit();
        }
      },
      loadLiqForm() {
        if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
          let [subscriptionPlan,monthPlan] = [this.form.subscriptionPlan,this.form.monthPlan];
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
        return this.$store.getters.payments.liqForm;
      }
    },
  }
</script>

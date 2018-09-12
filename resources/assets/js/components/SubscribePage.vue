<template>
    <div v-if="checkToken" class="cabinet-page" >
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Subscription</h4>
                <form action="your-server-side-code" method="POST" id="asdasd">
                </form>
                <form action="paypal/pay" method="POST" class="paypal-form">
                    <div class="form-group">
                        <label for="subscriptionPlan">Select subscription plan:</label>
                        <select
                                v-model="form.subscriptionPlan"
                                class="form-control"
                                name="subscription_plan_id"
                                id="subscriptionPlan">
                            <option value=0 selected disabled>Select subscription plan</option>
                            <option v-for="subscriptionPlan in subscriptionPlans"
                                    v-bind:value="subscriptionPlan.id"
                                    :key="subscriptionPlan.id">
                                {{subscriptionPlan.name}} cost {{subscriptionPlan.price}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monthPlan">Select month plan:</label>
                        <select
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
                        <img src="\images\stripe.png"
                             alt="stripe icon"
                             @click="stripeShow = true">
                        <form action="stripe/subscription" method="POST" v-show="stripeShow">
                            <!--this is form will submit to your action with any params what you need-->
                            <button type="button"
                                    class="stipeButton"
                                    @click.prevent="checkout">Pay with Card</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<style scoped>
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
    .stipeButton{
        display: block;
        min-height: 30px;
        position: relative;
        padding: 0 12px;
        height: 30px;
        line-height: 30px;
        background: #1275ff;
        background-image: linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
        font-size: 14px;
        color: #fff;
        font-weight: bold;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
        border-radius: 4px;
        user-select: none;
        cursor: pointer;
        border: 1px solid #1275ff;
    }
</style>
<script>
  import { mapGetters } from 'vuex';
  export default {
    data(){
      return {
        form : {
          subscriptionPlan : 0,
          monthPlan : 0,
        },
        stripeShow:false,
        // configure for stipe button
        handler : StripeCheckout.configure({
          key: 'pk_test_rYqZCPeTboW9LwXQUqToYR9Q',
          image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
          locale: 'auto',
          token: token => {
            // You can access the token ID with `token.id`.
            // Get the token ID to your server-side code for use.
            if(token){
              let csrf = document.head.querySelector('meta[name="csrf-token"]').content;
              let user_id = this.profileData.id;

              let discount = null;
              switch (this.monthPlans[this.form.monthPlan -1].monthes) {
                case 3:
                  discount = 'three-month';
                  break;
                case 6:
                  discount = 'six-month';
                  break;
                case 12:
                  discount = 'year';
                  break;
                default:
                  discount = null;
              }

              let plan = this.subscriptionPlans[this.form.subscriptionPlan - 1].name;
              axios
                .post('stripe/subscribe',{
                  user_id,
                  'X-CSRF-TOKEN':csrf,
                  token,
                  discount,
                  plan
                }).then(
                success => {
                  console.log(success);
                },
                err => {
                  console.log(err)
                }
              )
            }
          }
        })
      }
    },
    mounted() {
      this.$store.dispatch('getSubscribeData');
      this.$store.commit('loadProfile');

      // Close Checkout on page navigation:
      window.addEventListener('popstate', function() {
        this.handler.close();
      });
    },
    methods: {
      checkout(){
        this.handler.open({
          name: 'Subscription',
          description:`Pay for ${this.monthPlans[this.form.monthPlan -1].monthes} month`,
          email:this.profileData.email,
          amount: this.amount
        });
      },
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
      }
    },
    computed: {
      ...mapGetters(['profileData']),
      checkToken () {
        return this.$store.getters.checkToken;
      },
      currentStreamer () {
        return this.$store.getters.currentStreamer;
      },
      subscriptionPlans () {
        return this.$store.getters.subscriptionPlans;
      },
      monthPlans () {
        return this.$store.getters.monthPlans;
      },
      payReady () {
        if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
          return true;
        } else {
          return false;
        }
      },
      payments () {
        return this.$store.getters.payments.liqForm;
      },
      amount(){
        let costMonthes = this.subscriptionPlans[this.form.subscriptionPlan-1].cost * this.monthPlans[this.form.monthPlan -1].monthes;
        let precent = (costMonthes * this.monthPlans[this.form.monthPlan -1].percent) / 100;
        let sum = costMonthes -precent ;
        return parseFloat((sum.toFixed(2) + '').replace('.',''))
      }
    },
  }

</script>

<template>
    <div v-if="checkToken" class="cabinet-page" >
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Subscription</h4>
                <form action="your-server-side-code" method="POST" id="asdasd">
                </form>
                <form action="paypal/pay" method="POST" id="paypal-form">
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
                                {{subscriptionPlan.name}} cost {{subscriptionPlan.cost}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pay-type">Select payment service:</label>
                        <select
                            v-model="form.payService"
                            class="form-control"
                            id="pay-type"
                            v-on:change="form.monthPlan=0"
                        >
                            <option value='' selected disabled>Select pay service</option>
                            <option value='paypal'>PayPal</option>
                            <option value='liqpay'>Liqpay</option>
                            <option value='stripe'>Stripe</option>
                            <option value='yandex'>Yandex</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="form.payService !=''">
                        <label for="monthPlan">Select your discount:</label>
                        <select
                                v-model="form.monthPlan"
                                class="form-control"
                                name="month_plan_id"
                                id="monthPlan">
                            <option value=0 selected disabled>Select discount</option>
                            <option 
                                v-for="monthPlan in monthPlans" :key="monthPlan.id"
                                v-bind:value="monthPlan.id"
                                v-if="monthPlan.monthes == 1 || monthPlan.monthes == 12 || form.payService == 'stripe' || form.payService == 'paypal'"
                            >
                                {{monthPlan.monthes}} monthes subscription. Discount {{monthPlan.percent}} %
                            </option>
                        </select>
                    </div>
                    <input type="hidden" v-bind:value="currentStreamer.user_id" name="user_id">
                    <input type="hidden" value="subscription" name="type">
                </form>
                <div v-if="payReady" class="pay-enable row">
                    <button class="btn btn-lg btn-success" @click.prevent="payClick()">PAY SUBSCRIBE</button>
                    <div v-html="payments" id="liq-pay" style="display:none"></div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<style scoped lang="scss">
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
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .pay-enable div img {
        cursor: pointer;
        width: 100px;
    }
    .pay-enable>button {
        display: block;
        margin: 10px auto;
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
    /* modal style */
    .modal-header button.close{
        top: 10px;
        right: 10px;
        position: absolute;
    }
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
        position: relative;

    }

    .modal-container {
        width: 400px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }


    div.modal-body {
        margin: 20px 0;
        display:flex;
        flex-direction:column;
        align-items: start;
    }

    .modal-default-button {
        float: right;
    }
    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
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
          payService : '',
        },
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
              axios
                .post('stripe/subscribe',{
                  user_id,
                  'X-CSRF-TOKEN':csrf,
                  token,
                  discount : this.monthPlan,
                  plan : this.subscriptionPlan,
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
      setInterval(function(){
          const liqForm = document.querySelector('#liq-pay>form');
          if (liqForm) {
              liqForm.submit();
          }
        }, 1000);
    },
    methods: {
      yandexSubstr(){
        alert('to be announced');
      },
      checkout(){
        let amount = parseFloat((this.amount.toFixed(2) + '').replace('.',''))
        this.handler.open({
          name: 'Subscription',
          description:`Pay for Gamificator platform`,
          email:this.profileData.email,
          amount
        });
      },
      submitAction() {
        if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
          document.getElementById('paypal-form').submit();
        }
      },
      loadLiqForm() {
        if (this.form.subscriptionPlan > 0 && this.form.monthPlan > 0) {
          let [subscriptionPlan,monthPlan] = [this.form.subscriptionPlan,this.form.monthPlan];
          const data = {
            subscriptionPlan,
            monthPlan,
            user_id: this.currentStreamer.user_id,
            amount: this.amount
          };
          this.$store.dispatch('getLiqFormAction', data);
        }
      },
        payClick() { // main pay button
            if (this.form.payService == 'paypal') {
                document.getElementById('paypal-form').submit();
            }
            if (this.form.payService == 'liqpay') {
                this.loadLiqForm();
                if (this.$store.getters.payments.liqForm != '') {
                    document.querySelector('#liq-pay>form').submit();
                }
            }
            if (this.form.payService == 'yandex') {
                alert('to be anonced');
            }
            if (this.form.payService == 'stripe') {
                this.checkout();
            }
        },
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
            } 
            return false;
        },
        payments () {
            return this.$store.getters.payments.liqForm;
        },
        amount(){
            let costMonthes = this.subscriptionPlans[this.form.subscriptionPlan-1].cost * this.monthPlans[this.form.monthPlan -1].monthes;
            let precent = (costMonthes * this.monthPlans[this.form.monthPlan -1].percent) / 100;
            return (costMonthes -precent) ;
        },
        
    },
  }

</script>

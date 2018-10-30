<template>
    <div class="main-wrap">
        <div v-if="checkToken" class="shop">
            <h1>SHOP</h1>
            <div class="row">
                <div class="col-md-6">
                    <h2>Diamonds</h2>
                    <div v-for="diamond in diamonds" class="diamonds" :key="diamond.id">
                        <span>
                            <i class="fa fa-diamond"></i>
                            x {{diamond.amount}} = {{diamond.cost}} $
                        </span>
                        <form method="POST" action="paypal/pay">
                            <input type="hidden" v-bind:value="diamond.id" name="diamonds_set_id">
                            <input type="hidden" v-bind:value="currentViewer.user_id" name="user_id">
                            <input type="hidden" value="buy_diamonds" name="type">
                            <button type="submit" class="btn btn-success">buy</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>Cases</h2>
                    <div v-for="caseType in caseTypes" class="cases"  :key="caseType.id">
                        <img v-bind:src="'storage/' + caseType.image" v-bind:alt="caseType.name">
                        <button @click.prevent="showConfirmModal(caseType, 'coins')" class="btn btn-warning">
                            {{caseType.price}}
                            <i class="fa fa-copyright"></i>
                            buy
                        </button>
                        <button  @click.prevent="showConfirmModal(caseType, 'diamonds')" class="btn btn-success">
                            {{caseType.diamonds}}
                            <i class="fa fa-diamond"></i>
                            buy
                        </button>
                    </div>
                </div>
            </div>
            <modal-confirm
                v-bind:text="modal.title"
                v-bind:opened="modal.open"
                v-on:close-confirm-modal="modal.open=false"
                v-on:confirm-success="buy"
            ></modal-confirm>
            <div v-if="winItems && boxOpened" class="shop-modal">
                <div class="shop-box case-box">
                    <h2>{{ boxName }}</h2>
                    <img v-bind:src="'storage/' + boxImage" v-bind:alt="boxName">
                    <p>You can open case in your personal cabinet</p>
                    <div>
                        <a href="#/cabinet" class="btn btn-primary pull-left">go to cabinet</a>
                        <button @click.prevent="boxOpened=false" class="btn btn-success pull-right">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!checkToken" class="shop">
            <h2>Login to go to the shop</h2>
        </div>
        <right-part></right-part>
    </div>
</template>
<script>
import { mapGetters} from 'vuex';

    export default {
        data() {
            return {
                buying: {
                    id: 0,
                    valute: ''
                },
                modal : {
                    open : false,
                    title : ''
                },
                boxOpened: true,
                boxName: '',
                boxImage: '',
                phone: '',
                code: '',
                smsSended: false,
                openAlertModal: false,
            }
        },
        mounted() {
            this.$store.commit('getDiamondsList');
            this.$store.commit('getCaseTypesList');
            this.$store.commit('loadProfile');
        },
        methods: {
            showConfirmModal(item, valute) {
                this.buying.id = item.id;
                this.buying.valute = valute;
                const cost = (valute == 'coins') ? item.price + ' coins' : item.diamonds + ' diamonds';
                this.modal.title = 'Buy ' + item.name + ' case by ' + cost;
                this.boxName = item.name;
                this.boxImage = item.image;
                this.modal.open = true;
            },
            buy() {
                this.modal.open = false;
                this.$store.dispatch('buyCaseAction', this.buying);
            },
        },
        computed: {
            ...mapGetters([
				'checkToken',
                'diamonds',
                'diamondsLoaded',
                'caseTypes',
                'caseTypesLoaded',
                'winItems',
                'winedItems',
                'winedPrizes',
                'currentViewer',
			]),
            checkedCode: function () {
                const result = this.$store.getters.checkedCode;
                if (result === 'true') {
                    this.$store.commit('loadProfile');
                }
                if (result === 'false') {
                    this.openAlertModal = true;
                    this.smsSended = false;
                }
                return result;
            },
            profileData: function () {
                const data = this.$store.getters.profileData;
                if (data.phone && this.phone == '') {
                    this.phone = data.phone;
                }
                return data;
            },
        },
    }
</script>
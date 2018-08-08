<template>
    <div class="main-wrap">
        <div v-if="checkToken" class="shop">
            <h1>SHOP</h1>
            <div class="row">
                <div class="col-md-6">
                    <h2>Diamonds</h2>
                    <div v-for="diamond in diamonds" class="diamonds">
                        <span>
                            <i class="fa fa-diamond"></i>
                            x {{diamond.amount}} = {{diamond.cost}} $
                        </span>
                        <button class="btn btn-success">buy</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>Cases</h2>
                    <div v-for="caseType in caseTypes" class="cases">
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
            <div v-if="winItems" class="shop-modal">
                <div class="shop-box case-box">
                    <h2>{{ boxName }}</h2>
                    <img v-bind:src="'storage/' + boxImage" v-bind:alt="boxName">
                    <button @click.prevent="openBox()" class="btn btn-success">open case</button>
                </div>
            </div>
            <div v-if="boxOpened" class="shop-modal">
                <div class="shop-box items-box">
                    <h3 v-if="winedItems.length > 0">Win items:</h3>
                    <div v-for="item in winedItems">
                        <img v-bind:src="'storage/' + item.icon" v-bind:alt="item.title">
                        <h5>{{ item.title }}</h5>
                    </div>
                    <h3 v-if="winedPrizes.length > 0">Win prizes:</h3>
                    <div v-for="item in winedPrizes">
                        <img v-bind:src="'storage/' + item.image" v-bind:alt="item.name">
                        <h5>{{ item.name }}</h5>
                    </div>
                    <button @click.prevent="getModalItems()" class="btn btn-success">GET</button>
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
                boxOpened: false,
                boxName: '',
                boxImage: '',
            }
        },
        mounted() {
            this.$store.commit('getDiamondsList');
            this.$store.commit('getCaseTypesList');
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
            openBox() {
                this.boxOpened = true;
                this.$store.dispatch('flashWinItems');
            },
            getModalItems() {
                this.boxOpened = false;
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
			]),
        },
    }
</script>
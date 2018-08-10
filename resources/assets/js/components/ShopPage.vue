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
                    <section v-if="winedPrizes.length > 0" class="">
                        <p>To receive your prize please confirm your contacts</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="contact-country">Country:</span>
                            </div>
                            <input v-model="currentViewer.contacts.country" type="text" class="form-control" aria-label="Country..." aria-describedby="contact-country">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="contact-city">City:</span>
                            </div>
                            <input v-model="currentViewer.contacts.city" type="text" class="form-control" aria-label="City..." aria-describedby="contact-city">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="contact-zip">Zip-code</span>
                            </div>
                            <input v-model="currentViewer.contacts.zip_code" type="text" class="form-control" aria-label="Zip-code..." aria-describedby="contact-zip">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="contact-address">Local address</span>
                            </div>
                            <input v-model="currentViewer.contacts.local_address" type="text" class="form-control" aria-label="Local address..." aria-describedby="contact-address">
                        </div>
                         <div v-if="!profileData.verified">
                        <div v-if="!smsSended" class="form-inline">
                            <input
                                v-model="phone"
                                placeholder="Phone..."
                                class="form-control"
                            >
                            <button
                                @click.prevent="sendSMS()"
                                placeholder="Code..."
                                class="btn btn-success"
                            >
                                send SMS
                            </button>
                        </div>
                        <div
                            v-if="smsSended"
                            class="form-inline"
                        >
                            <input
                                v-model="code"
                                class="form-control"
                            >
                            <button
                                @click.prevent="checkCode()"
                                class="btn btn-success"
                            >
                                check Code
                            </button>
                        </div>
                        <modal-alert
                            v-if="checkedCode==='false'"
                            AlertType="warning"
                            v-bind:messages="['code wrong']"
                            v-bind:opened="openAlertModal"
                            v-on:close-alert-modal="openAlertModal=false"
                        ></modal-alert>
                    </div>
                    </section>
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
            openBox() {
                this.boxOpened = true;
                this.$store.dispatch('flashWinItems');
            },
            getModalItems() {
                if (this.winedPrizes.length > 0) {
                    let canSave = true;
                    if (this.currentViewer.contacts.country == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.city == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.zip_code == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.local_address == '') {
                        canSave = false;
                    }
                    if (!this.profileData.verified) {
                        canSave = false;
                    }
                    if (canSave) {
                        this.$store.dispatch('updateViewerContacts', this.currentViewer.contacts);
                        this.boxOpened = false;
                    }
                } else {
                    this.boxOpened = false;
                }
            },
            sendSMS() {
               this.$store.commit('sendSMS', this.phone);
               this.smsSended = true;
            },
            checkCode() {
                this.$store.dispatch('checkCodeAction', this.code);
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
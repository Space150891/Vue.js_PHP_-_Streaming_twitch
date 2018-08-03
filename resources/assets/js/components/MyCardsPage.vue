<template>
    <div v-if="checkToken" class="cabinet-page mycards" >
        <h1 class="text-center">My cards</h1>
        <div class="cards">
            <div
                v-for="myCard in myCards"
            >
                <viewer-card
                    v-bind:frame="myCard.frame"
                    v-bind:hero="myCard.hero"
                    v-bind:achivement="myCard.achievement"
                ></viewer-card>
                <div class="action-block">
                    <button
                        v-if="myCard.promoted == false"
                        @click.prevent="setMain(myCard.id)"
                        class="btn btn-warning"
                    >
                        <i class="fa fa-home"></i>
                    </button>
                    <span v-if="myCard.promoted" >MAIN</span>
                    <button @click.prevent="deleteCard(myCard.id)" class="btn btn-danger pull-right">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 frames">
                <h3 class="text-center">frames</h3>
                <label
                    v-for="item in myItems"
                    v-if="item.type=='frame'"
                >
                    <img v-bind:src="'storage/' + item.icon" v-bind:alt="item.title">
                    <p>{{item.title}}</p>
                    <input type="radio" name="frame" v-bind:value="item.id" v-model="newCard.frame_id">
                    <i class="fa fa-check"></i>
                </label>
            </div>
            <div class="col-md-4 heroes">
                <h3 class="text-center">heroes</h3>
                <label
                    v-for="item in myItems"
                    v-if="item.type=='hero'"
                >
                    <img v-bind:src="'storage/' + item.icon" v-bind:alt="item.title">
                    <p>{{item.title}}</p>
                    <input type="radio" name="hero" v-bind:value="item.id"  v-model="newCard.hero_id">
                    <i class="fa fa-check"></i>
                </label>
            </div>
            <div class="col-md-4 achivements">
                <h3 class="text-center">achivements</h3>
                <label
                    v-for="achivement in achivements"
                >
                    <p>{{achivement.name}}</p>
                    <input type="radio" name="achivement" v-bind:value="achivement.id"  v-model="newCard.achivement_id">
                    <i class="fa fa-check"></i>
                </label>
            </div>
            <button @click.prevent="createCard()" class="btn btn-success create-card-but">
                CREATE CARD
            </button>
            <modal-delete 
			    name="Card"
			    v-bind:opened="deletingModal"
			    v-on:close-delete-modal="deletingModal=false"
			    v-on:confirm-delete="deleteAction"
			></modal-delete>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                newCard : {
                    frame_id : 0,
                    hero_id : 0,
                    achivement_id : 0
                },
                deletingModal: false,
                deletingId: 0,
            }
        },
        mounted() {
            if (this.checkToken) {
                this.loadAll();
            }
        },
        methods: {
           loadAll() {
               this.$store.dispatch('loadMyCardsPage');
           },
           createCard() {
               if (this.newCard.frame_id > 0 && this.newCard.hero_id > 0 && this.newCard.achivement_id > 0) {
                   this.$store.dispatch('createCardAction', this.newCard);
               }
           },
           deleteCard(cardId) {
               this.deletingId = cardId;
               this.deletingModal = true;
           },
           deleteAction() {
               this.deletingModal=false;
               this.$store.dispatch('deleteCardAction', this.deletingId);
           },
           setMain(cardId) {
               this.$store.dispatch('setMainCardAction', cardId);
           }
        },
        computed: {
            ...mapGetters([
				'checkToken',
				'myItems',
                'myCards',
                'achivements',
			]),
        },

    }
</script>
<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">Achivements</h1>
        <div class="row">
            <div class="col-md-4 achivement-block" v-for="achivement in achivements" :key="achivement.id">
                <div class="achivement-panel">
                    <img v-if="achivement.image" v-bind:src="'storage/' + achivement.image">
                    <div v-if="!achivement.image" class="avatar"></div>
                    <h4>{{achivement.description}}</h4>
                    <h5>unlocked {{achivement.unlocked_at.substr(0, 10)}}</h5>
                </div>
            </div>
            <div class="col-md-4 achivement-block" v-for="achivement in customAchivements"  :key="achivement.id">
                <div class="achivement-panel">
                    <img v-bind:src="achivement.image">
                    <h4>{{achivement.text}}</h4>
                    <h5>unlocked {{achivement.updated_at.substr(0, 10)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            this.$store.commit('loadAchivements');
        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            achivements: function () {
                return this.$store.getters.achivements;
            },
            customAchivements: function () {
                return this.$store.getters.viewerCustomAchievements;
            },
        },
    }
</script>
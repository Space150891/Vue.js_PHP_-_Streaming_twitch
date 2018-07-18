<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">Achivements</h1>
        <div class="row">
            <div class="col-md-4 achivement-block" v-for="achivement in achivements" >
                <div class="achivement-panel">
                    <div class="avatar"></div>
                    <h4>{{achivement.description}}</h4>
                    <h5>unlocked {{achivement.unlocked_at.date.substr(0, 10)}}</h5>
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
        },
    }
</script>
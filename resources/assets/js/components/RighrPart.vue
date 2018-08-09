<template>
<div class="rightPart-main">
    <div class="rightPart">
        <div v-for="(item) in lastPrizes" class="rightPart-item" >
            <div class="rightPart-img">
                <img v-bind:src="'storage/' + item.image" v-bind:alt="item.name">
            </div>
            <div class="rightPart-mainText">
                <h2>{{ item.name }}</h2>
                <p>{{ item.description }}</p>
            </div>
        </div>
    </div>
    
    
    
</div>
</template>

<script>
import { mapGetters} from 'vuex';

    export default {
        mounted() {
            this.$store.dispatch('getLastPrizesAction');
        },
        computed: {
            ...mapGetters([
                'lastPrizes'
			]),
        },
    }
</script>
<style lang="scss">
    
    .rightPart-main {
        width: 15%;
        height: 100vh;
        margin-top: 111px;
    }
    .rightPart {
        width: 100%;
        display: inline-block;
        height: calc(100vh - 16vh);
        position: static;
        z-index: -20;
        padding-left: 2px;
    }
    .rightPart-item {
        display: flex;
        justify-content: center;
        width: 100%;
        height: auto;
        border-bottom: 1px solid black;
        padding-bottom: 10%;
        margin-bottom: 20px;
        cursor: pointer;
        text-decoration: none;
        color: black;
    }
    .rightPart-img {
        width: 33%;
        img{
            width: 90px;
            height: 90px;
            border: 2px solid black;
        }    
    }
    .rightPart-mainText {
        width: 59%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        word-wrap:break-word;

        h2 {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
            padding: 0;

        }
        p {
            font-size: 15px;
            line-height: 10px;
            
        }
    }
    
    @media screen and (max-width: 1471px)  {
        .rightPart-item {
            justify-content: space-between;
        }
        .rightPart-img {
            img {
                width: 55px;
                height: 55px;
            }
        }
        .rightPart-mainText {
            text-align: center;
            h2 {
                font-size: 16px;
            }
            p {
                font-size: 13px;
            }
        }
    }

    @media screen and (max-width: 1085px)  {
        .rightPart-item {
            justify-content: space-between;
        }
        .rightPart-img {
            img {
                width: 35px;
                height: 35px;
            }
        }
        .rightPart-mainText {
            h2 {
                font-size: 13px;
            }
            p {
                font-size: 12px;
            }
        }
        
    }

    @media screen and (max-width: 991px)  {
        .rightPart-main {
            margin-top: 73px;
        }
    }
    
    @media screen and (max-width: 775px)  {
        .rightPart-item {
            justify-content: space-between;
        }
        .rightPart-img {
            img {
                width: 30px;
                height: 30px;
            }
        }
        .rightPart-mainText {
            h2 {
                font-size: 12px;
            }
            p {
                font-size: 11px;
            }
        }
    }
    
</style>


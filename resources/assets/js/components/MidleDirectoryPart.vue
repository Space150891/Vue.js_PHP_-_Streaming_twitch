<template>
    <div class="midle-directory" >
        <div class="scroll">
            <div class="container-fluid ">
                <div class="row flex-pos">
                    <div v-if="currentGame">
                        <h1>
                            {{currentGame}} 
                            <button @click.prevent="showAll()" class="btn btn-default">
                                change game
                            </button>
                        </h1>
                        <div class="row">
                            <div v-if="streamsLoaded" v-for="stream in streams" class="directory-streamers col-md-4">
                                <iframe
                                    v-bind:src="'https://player.twitch.tv/?channel=' + stream.name"
                                    height="300px"
                                    width=100%
                                    frameborder="0"
                                    scrolling="no"
                                    allowfullscreen="false">
                                </iframe>
                                <h5>{{ stream.name }}</h5>
                            </div>
                        </div>
                        <div v-if="!streamsLoaded"  class="v-loading"></div>
                    </div>
                    <div v-if="!currentGame" v-for="(item) in games" class="dir-bg col-lg-3 dir-mdd col-sm-6 col-12 directory-items" >
                        <a href="#" @click.prevent="setCurrent(item.name)">
                            <img class="price-image" v-bind:src="item.avatar" v-bind:alt="item.name" >
                            <h2>{{ item.name }}</h2>
                        </a>
                    </div>
                    
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <footer>
                            <footer-part></footer-part>            
                        </footer>
                    </div>
                </div>
             </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentGame : false,
            }
        },
        mounted() {
            this.$store.commit('loadGames');
        },
        methods: {
           setCurrent(gameName) {
               this.$store.commit('loadStreamersByGame', gameName);
               this.currentGame = gameName;
           },
           showAll() {
               this.$store.commit('flashStreamers');
               this.currentGame = false;
           },
        },
        computed: {
            games: function () {
                return this.$store.getters.games;
            },
            streams: function () {
                return this.$store.getters.streamers;
            },
            streamsLoaded: function () {
                return this.$store.getters.streamersLoaded;
            },
        },
    }
</script>
<style lang="scss">
    body {
        overflow: hidden;
    }
    .midle-directory {
        width: 75%;
        height: 89vh;
        margin-left: 15%;
        margin-top: 109px;
        overflow-y: scroll;
    }
    .flex-pos {
        justify-content: center;
        cursor: pointer;
        a, a:hover {
            text-decoration: none;
            color: #333;
        }
        h2 {
            height: 67px;
            word-wrap: break-word;
            overflow-y: hidden;
        }
    }
    .directory-items {
        margin-bottom: 20px;
        img {
            width: 100%;
            height: auto;
        }
    }

    .directory-streamers {

    }

    @media screen and (min-width: 1200px)  {
        .dir-bg {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

   
    @media (min-width: 760px) and (max-width: 1029px)  {
        .dir-mdd {
            flex: 0 0 33%;
            max-width: 33%;
        }
    }

     @media (max-width: 991px) {
       .midle-directory {
            margin-top: 69px;
        }
    }

    @media (max-width: 575px) {
       .directory-items {
           text-align: center;
            img {
                width: 60%;
                height: auto;
            }
        }
    }
   
</style>


<template>
    <div class="midle-directory" >
        <div class="scroll">
            <div class="container-fluid ">
                <div class="row flex-pos">
                    <div v-if="currentGame">
                        <h1 class="directory-game-header">
                            {{currentGame}} 
                            <button @click.prevent="showAll()" class="btn btn-default">
                                change game
                            </button>
                            <button
                                v-if="selected.length == 1 || selected.length == 2 || selected.length == 4"
                                @click.prevent="watchStreams()"
                                class="btn btn-success"
                            >
                                watch
                                {{selected.length}}
                                streams
                            </button>
                        </h1>
                        <div class="row">
                            <div
                              v-if="streamsLoaded"
                              v-for="stream in streams"
                              @click="select(stream.name)"
                              class="dir-bg col-lg-3 dir-mdd col-sm-6 col-12 directory-items"
                            >
                                <img 
                                  class="price-image"
                                  v-bind:src="stream.avatar ? backPublic + '/' + stream.avatar : backPublic + '/images/tvitch-question.png'"
                                  v-bind:alt="stream.name" 
                                >
                                <h2>
                                    {{ stream.name }}
                                    <img
                                      v-if="selected.indexOf(stream.name) > -1"
                                      v-bind:src="backPublic + '/images/logo.png'"
                                      style="width:20px;"
                                    >
                                </h2>
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
var config = require('./config/config.json');
    export default {
        data(){
            return {
                currentGame : false,
                backPublic : config.baseUrl,
                selected : [],
            }
        },
        mounted() {
            this.$store.commit('loadGames');
            this.clearSelected();
        },
        methods: {
           setCurrent(gameName) {
               this.clearSelected();
               this.$store.commit('loadStreamersByGame', gameName);
               this.currentGame = gameName;
           },
           showAll() {
               this.clearSelected();
               this.$store.commit('flashStreamers');
               this.currentGame = false;
           },
           select(streamerName) {
                const pos = this.selected.indexOf(streamerName);
                if (pos > -1) {
                    this.selected.splice(pos, 1);
                } else {
                    this.selected.push(streamerName);
                }
           },
           watchStreams() {
               this.$store.commit('setWatchingStreams', this.selected);
               window.location.assign('#/watch-streams');
           },
           clearSelected() {
               this.selected = [];
               this.$store.commit('clearWatchingStreams');
           }
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
        margin-top: 150px;
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

    .directory-game-header {
        text-align: center;
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


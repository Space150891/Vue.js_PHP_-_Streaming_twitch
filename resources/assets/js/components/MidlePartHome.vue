<template>
    <div class="midle-home">
        <div class="scroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="midle-home-content">
                            <h2>{{mainContent.mainHeader}}</h2>
                            <div  v-html="mainContent.mainText"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid iframe-part">
                <div class="row">
                    <div class="col-sm-12 col-lg-8">
                        <div class="video-part">
                            <iframe
                                v-bind:src="'https://player.twitch.tv/?channel=' + this.mainChannel"
                                width=100%
                                height="100%"
                                frameborder="0"
                                scrolling="no"
                                allowfullscreen="false">
                            </iframe>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 chat-part-mrt">
                        <div class="chat-part">
                            <iframe frameborder="1"
                                scrolling="true"
                                v-bind:src="'https://www.twitch.tv/embed/' + this.mainChannel +'/chat'"
                                height="100%"
                                width="100%">
                            </iframe>
                        </div>
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
import { mapGetters} from 'vuex';
export default {
    data: () => {
        return {
            switcher : false,
        }
    },
    mounted() {
		this.getContent();
        this.channelSwitcher();
	},
    destroyed() {
        if (this.switcher) {
            clearInterval(this.switcher);
        }
    },
    methods: {
		getContent: function () {
			this.$store.commit('getMainContent');
		},
        channelSwitcher: function () {
            let storage = this.$store;
            storage.commit('getMainChannel');
            this.switcher = setInterval(function(){
                storage.commit('getMainChannel');
            }, 10 * 1000);
        },
    },
    computed: {
		...mapGetters([
			'mainContent',
            'mainContentLoaded',
            'mainChannel',
		]),
    }
}
</script>

<style lang="scss">
    body {
        overflow: hidden;
    }
    .midle-home {
        width: 75%;
        height: 89vh;
        margin-left: 15%;
        margin-top: 109px;
        overflow-y: scroll;
    }
    .midle-home-content {
        height: auto;
        margin: 0.5%;
        padding: 0.5% 1%;
        text-align: justify;
        h2 {
            text-align: center;
            font-size: 1.3rem;
        }
    }
    .iframe-part {
        padding-bottom: 8%;
    }
    .video-part {
        width: 100%;
        height: 62vh;
        margin-right: 1%;
    }
    .chat-part {
        width: 100%;
        height: 100%;
    }
    
    @media (max-width: 991px) {
       .midle-home {
            margin-top: 72px;
            height: 88vh;
        }
        .iframe-part {
            padding-bottom: 10%;
        }
        .chat-part-mrt{
            margin-top: 10px;
        }
        .chat-part {
            height: 62vh;
        }
    }
    
</style>


<template>
    <div>
        <ul class="nav nav-pills  flex-column flex-sm-row nav-chat">
            <li class="nav-item chat-item" v-for="(chat, index) in chats">
                <a 
                  v-bind:class="[(index == selected) ? 'active' : '', 'flex-sm-fill text-sm-center nav-link']"
                  href="#"
                  :key="index"
                  @click.prevent="setSelected(index)"
                > 
                    Chat {{ index +1 }}
                </a>
            </li>
        </ul>
        <iframe frameborder="1"
            scrolling="true"
            v-bind:src="chats[selected]"
            height="730px"
            width="100%">
        </iframe>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: 0,
                chats: channelsUrl,
            }
        },
        methods: {
            setSelected(index) {
                this.selected = index;
            }
        },
        mounted() {
            console.log('Tabs mounted', this.chats);
        },
    }
</script>
<style lang="scss">
    @media (max-width: 1262px) {
        .nav-chat {
            margin-bottom: 1%;
        }
        .chat-item {
            a {
                width: 77%;
                padding: 2px;
            }
        }
    }
    @media (max-height: 840px) {
        .video-iframe-item {
            iframe {
                height: 250px;
            }
            
        }
    }
    @media (max-width: 767px) {
        
        h3 {
            margin-top: 20px;
        }
        .toggle-block {
            .social{
                bottom: 80px;
                right: 30px;
            }
        }
        .nav-chat {
            display: flex;
            align-items: center;
            text-align: center;
        }
        .video-iframe-chat {
            iframe {
                height: 450px;
                margin: 0 2px;
            }
        }
        .rightPart-main {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .rightPart {
            width: 50%;
        }
        .rightPart-item {
            width: 100%;
        }
        .rightPart-img {
            width: 45%;
            img {
                width: 100%;
                height: 100%;
            }
        }
        .rightPart-mainText {
            width: 55%;
            h1 {
                font-size: 20px;
            }
            p {
                font-size: 15px;
            }
        }
        .navbar {
            position: fixed;
            width: 100%;
            z-index: 100;
        }
        .navbar-toggler {
            margin-right: 10px;
        }


    }
</style>


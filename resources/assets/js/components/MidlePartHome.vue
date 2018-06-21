<template>
    <div class="midle-home">
        <div class="midle-home-content">
            CONTENT
        </div>
        <div class="midle-home-iframes">
            <div class="video-part">
                <iframe
                    src="https://player.twitch.tv/?channel=ubah"
                    width=100%
                    height="100%"
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="false">
                </iframe>
            </div>
            <div class="chat-part">
                <iframe frameborder="1"
                    scrolling="true"
                    src="https://www.twitch.tv/embed/ubah/chat"
                    height="100%"
                    width="100%">
                </iframe>
            </div>
        </div>

    </div>
</template>

<style lang="scss">
    .midle-home {
        width: 75%;
        margin-left: 15%;
        margin-top: 111px;
    }
    .midle-home-content {
        width: 99%;
        height: 30%;
        text-align: center;
        background: #dcdcdc;
        margin: 0.5%;
    }
    .midle-home-iframes {
        display: flex;
        justify-content: start;
        height: 55vh;
        margin: 2%;
    }
    .video-part {
        width: 75%;
        margin-right: 1%;
    }
    .chat-part {
        width: 25%;
        height: 100%;
    }
    
    @media (max-width: 991px) {
       .midle-home {
            margin-top: 69px;
        }
    }
    
</style>


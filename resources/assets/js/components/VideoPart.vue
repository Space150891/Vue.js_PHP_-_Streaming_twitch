<template>
    <div class="video-part" >
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
    body {
        overflow: hidden;
    }
    .video-part {
        width: 85%;
    }
    .midle-home-iframes {
        display: flex;
        justify-content: start;
        height: 88vh;
        margin-top: 95px;
    }
    .chat-part {
        width: 15%;
    }

    @media (max-width: 991px) {
       .midle-home-iframes {
            margin-top: 47px;
        }
    }

</style>


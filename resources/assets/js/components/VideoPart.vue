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

<script>
    export default {
        data(){
            return {
                
            }
        },
    }
</script>
<style lang="scss">
    body {
        overflow: hidden;
    }
    main {
            display: flex;
            
        }
    .video-part {
        width: 85%;
        margin-top: 5%;   
    }
    
    .midle-home-iframes {
        display: flex;
        justify-content: start;
        height: 88vh;
   }
    
    .chat-part {
        width: 15%;
        height: 100%;
    }


    
   



</style>


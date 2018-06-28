<template>
    <div class="midle-home">
        <div class="scroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="midle-home-content">
                            <h2>CONTENT</h2>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi sed ratione optio natus, doloribus porro. Officiis pariatur qui repudiandae quidem, quasi non nostrum at molestiae iure perspiciatis odio tempore repellat neque. Dolores dolorum obcaecati debitis alias quibusdam molestiae laboriosam iusto molestias enim, itaque hic minima incidunt nemo voluptatem, laudantium voluptas consectetur animi sint corporis a ex. Vero eum, culpa corporis aliquid quisquam earum rem quaerat nulla sapiente adipisci quibusdam minus mollitia, quas optio illum deserunt voluptates dignissimos accusamus reprehenderit! Dolor praesentium quidem consequuntur hic placeat, corrupti adipisci ex? Praesentium quasi cum dignissimos voluptates aspernatur dicta! Laudantium, id officiis. Libero, error.  
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid iframe-part">
                <div class="row">
                    <div class="col-sm-12 col-lg-8">
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
                    </div>
                    <div class="col-sm-12 col-lg-4 chat-part-mrt">
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


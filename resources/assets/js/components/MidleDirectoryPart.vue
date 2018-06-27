<template>
    <div class="midle-directory" >
        <div class="container-fluid ">
            <div class="row flex-pos">
                <div v-for="(item) in directoryItems" class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12 directory-items" >
                    <img class="price-image" v-bind:src="item.image" v-bind:alt="item.imageName" >
                    <h2>{{ item.mainText }}</h2>
                    <p> {{ item.downText }} </p>
                </div>
                
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                directoryItems: [
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    {
                        mainText: "Text",
                        downText: "Text",
                        image:require('../../../../public/images/tvitch-question.png'),
                        imageName: "alt"
                    },
                    
                ]
            }
        },
    }
</script>
<style lang="scss">
    body {
        overflow: auto;
    }
    .midle-directory {
        width: 75%;
        margin-left: 15%;
        margin-top: 111px;
    }
    .flex-pos {
        justify-content: center;
    }
    .directory-items {
        margin-bottom: 20px;
        img {
            width: 100%;
            height: auto;
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


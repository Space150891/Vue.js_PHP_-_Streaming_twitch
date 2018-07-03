<template>
<div class="rightPart-main">
    <div class="rightPart">
        <div v-for="(item) in leftItems" class="rightPart-item" >
            <div class="rightPart-img">
                <img v-bind:src="item.image" v-bind:alt="item.imageName">
            </div>
            <div class="rightPart-mainText">
                <h1>{{ item.mainText }}</h1>
                <p>{{ item.downText }}</p>
            </div>
        </div>
    </div>
    
    
    
</div>
</template>

<script>
    export default {
        data(){
            return {
                leftItems: [
                    {
                        mainText: "Residentevil",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        downText: "Lorem ipsum dolor sit."
                    },
                    {
                        mainText: "superman",
                        image:require('../../../../public/images/superman.png'),
                        downText: "Lorem ipsum dolor sit.",
                        imageName: "alt"
                    },
                    {
                        mainText: "Liverpool",
                        image:require('../../../../public/images/Liverpool.png'),
                        downText: "Lorem ipsum dolor sit.",
                        imageName: "alt"
                    },
                    {
                        mainText: "Illuminati",
                        image:require('../../../../public/images/Illuminati.png'),
                        downText: "Lorem ipsum dolor sit.",
                        imageName: "alt"
                    },
                    {
                        mainText: "thelastofus",
                        image:require('../../../../public/images/thelastofus.png'),
                        downText: "Lorem ipsum dolor sit.",
                        imageName: "alt"
                    },
                    {
                        mainText: "CS",
                        image:require('../../../../public/images/cs.png'),
                        downText: "Lorem ipsum dolor sit.",
                        imageName: "alt"
                    }
                ]
            }
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

        h1 {
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
            h1 {
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
            h1 {
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
            h1 {
                font-size: 12px;
            }
            p {
                font-size: 11px;
            }
        }
    }
    
</style>


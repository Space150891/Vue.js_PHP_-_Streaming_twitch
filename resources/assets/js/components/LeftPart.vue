<template>
<div class="leftPart-main">
    <div class="scroll-item btn-up" @click.prevent="scrollUp()"><span class="leftPart-scroll"> > </span></div>
    <div class="leftPart">
        <div v-for="(item) in leftItems" class="leftPart-item" >
            <div class="leftPart-img">
                <img v-bind:src="item.image" v-bind:alt="item.imageName">
            </div>
            <div class="leftPart-mainText">
                <h1>{{ item.mainText }}</h1>
                <p>{{ item.mainText }}</p>
            </div>
            <div class="leftPart-rightText">
                <p>{{ item.rightText }}</p>
            </div>
        </div>
    </div>
    
    <div class="scroll-item btn-down" @click.prevent="scrollDown()"><span class="leftPart-scroll"> < </span></div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                num : 10,
                leftItems: [
                    {
                        mainText: "Text",

                        image:require('../../../../public/images/logo.png'),
                        imageName: "alt",
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logo.png'),
                        downText: "text",
                        rightText: "text"
                    }
                ]
            }
        },
        methods: {
            scrollUp() {
                const elemLeftPart = document.getElementsByClassName('leftPart')[0];
                const elemLeftPartH = elemLeftPart.offsetHeight;
                const elemItemH = document.getElementsByClassName('leftPart-item')[0].offsetHeight;
                let sum = -this.num;
                if(sum<elemLeftPartH){
                    this.num = this.num-elemItemH;
                    elemLeftPart.style.transform = "translate(0px,"+this.num+"px)";
                    elemLeftPart.style.transition = "transform 1s";
                }
            },
            scrollDown() {
                const elemLeftPart = document.getElementsByClassName('leftPart')[0];
                const elemLeftPartH = elemLeftPart.offsetHeight;
                const elemItemH = document.getElementsByClassName('leftPart-item')[0].offsetHeight;
                console.log(this.num)
                if(this.num<10){
                    this.num = this.num+(elemItemH);
                    elemLeftPart.style.transform = "translate(0px,"+(this.num+20)+"px)";
                    elemLeftPart.style.transition = "transform 1s";
                }
            },
        },
        mounted() {
            // console.log('Tabs mounted', this.menuItems);
        },
        
    }
</script>
<style lang="scss">
    
    .leftPart-main {
        position: relative;
        width: 15%;
        height: 100vh;
    }
    .leftPart {
        width: 100%;
        display: inline-block;
        height: calc(100vh - 16vh);
        transform: translate(0px, 37px);
        position: relative;
        z-index: -20;
        padding-left: 2px;
    }
    .scroll-item {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: absolute;
        width: 100%;
        height: 35px;
        z-index: 100;
        background-color: white;
        &:hover {
            background-color: #e4e4e4;
        }
        &:active {
            background-color: #b9b9b9;
            border-radius: 2px;
        }
    }
    .btn-up {
        border-bottom: 1px solid black;
        margin-bottom: 10px;
        top: 0px;
       }
    .btn-down {
        border-top:  1px solid black;
        bottom: 98px;
    }
    
    .leftPart-scroll {
        width: 10px;
        transform: rotate(-90deg);
        font-size: 20px;
    }
    .leftPart-item {
        display: flex;
        justify-content: space-around;
        width: 100%;
        height: auto;
        margin-bottom: 20px;
        cursor: pointer;
        text-decoration: none;
        color: black;

        &:hover {
            background-color: #e6e6e6;
            text-decoration: none;
            color: black;
        }
    }
    .leftPart-img {
        width: 33%;
        img{
            width: 90px;
            height: 90px;
            border: 2px solid black;
        }    
    }
    .leftPart-mainText {
        width: 33%;
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
        }
    }
    .leftPart-rightText {
        width: 33%;
        display: flex;
        flex-direction: column;
        justify-content: center;
         word-wrap:break-word;
        p {
            font-size: 15px;
        }
    }
    @media screen and (max-width: 1783px)  {
        .btn-down {
            bottom: 89px;
        }
    }
    @media screen and (max-width: 1569px)  {
        .btn-down {
            bottom: 79px;
        }
    }
    @media screen and (max-width: 1331px)  {
        .btn-down {
            bottom: 69px;
        }
    }

    @media screen and (max-width: 1471px)  {
        .leftPart-item {
            justify-content: space-between;
        }
        .leftPart-img {
            img {
                width: 55px;
                height: 55px;
            }
        }
        .leftPart-mainText {
            text-align: center;
            h1 {
                font-size: 16px;
            }
            p {
                font-size: 13px;
            }
        }
        .leftPart-rightText {
            p {
                font-size: 12px;
            }
        }
        .btn-down {
            height: 35px;
        }
    }

    @media screen and (max-width: 1085px)  {
        .leftPart-item {
            justify-content: space-between;
        }
        .leftPart-img {
            img {
                width: 35px;
                height: 35px;
            }
        }
        .leftPart-mainText {
            h1 {
                font-size: 13px;
            }
            p {
                font-size: 12px;
            }
        }
        .leftPart-rightText {
            p {
                font-size: 12px;
            }
        }
        .btn-down {
            bottom: 69px;
        }
    }
    @media screen and (max-width: 991px)  {
        .btn-down {
            bottom: 45px;
        }
    }
    @media screen and (max-width: 775px)  {
        .leftPart-item {
            justify-content: space-between;
        }
        .leftPart-img {
            img {
                width: 30px;
                height: 30px;
            }
        }
        .leftPart-mainText {
            h1 {
                font-size: 12px;
            }
            p {
                font-size: 11px;
            }
        }
        .leftPart-rightText {
            p {
                font-size: 11px;
            }
        }
        
    }

</style>


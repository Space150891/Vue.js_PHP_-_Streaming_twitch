<template>
    <div class="midle-price" >
        <div class="scroll">
            <div class="price-up-items">
                <div class="price-up-item" v-on:click="(setPrise(1))">Tier 1</div>
                <div class="price-up-item" v-on:click="(setPrise(2))">Tier 2</div>
                <div class="price-up-item" v-on:click="(setPrise(3))">Tier 3</div>
                <div class="price-up-item" v-on:click="(setPrise(4))">Tier 4</div>
                <div class="price-up-item" v-on:click="(setPrise(5))">Tier 5</div>
            </div>
            <div class="container-fluid ">
                <!-- paginate -->
                <paginate name="pricesItems" :per="15" :list="pricesItems" class="row flex-pos">
                    <div v-for="(item) in paginated('pricesItems')" class="col-xl-2 col-lg-3 col-md-4 col-sm-12 prices-items" >
                        <h2>{{ item.mainText }}</h2>
                        <img class="price-image" v-bind:src="item.image" v-bind:alt="item.imageName" >
                        <span> $ {{ price }}</span>
                    </div>
                </paginate>

                <paginate-links for="pricesItems" :limit="0" :show-step-links="true"></paginate-links>
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
        data(){
            return {
                priceDefault: 9.99,
                price: 9.99,
                pricesItems: [
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/BF2EF.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/ufc.png'),
                        imageName: "alt",
                    
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Illuminati.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/SH2.png'),
                        imageName: "alt",
                       
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/cs.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/superman.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/lastSurvivalist.png'),
                        imageName: "alt",
                        
                    },
                     {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Liverpool.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Colgate.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/Illuminati.png'),
                        imageName: "alt",
                        
                    },
                     {
                        mainText: "Text",
                        image:require('../../../../public/images/Residentevil.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/PUBG.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/pxEA.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/thelastofus.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/superman.png'),
                        imageName: "alt",
                        
                    },
                ],
                paginate: ['pricesItems']
            }
        },
        methods: {
            setPrise(index) {
                this.price = (this.priceDefault*index); 
            }
        },
    }
</script>
<style lang="scss">
    body {
        overflow: hidden;
    }
    .midle-price {
        width: 75%;
        height: 89vh;
        margin-left: 15%;
        margin-top: 109px;
        overflow-y: scroll;
    }
    .flex-pos {
        justify-content: center;
    }
    .paginate-list {
        width: 100%;
        list-style-type: none;
        padding: 0;
        li {
            display: inline-block;
        }
    }
    .paginate-links.pricesItems {
        user-select: none;
        display: flex;
        justify-content: center;
        margin-top: 2%;
        margin-bottom: 6%;
        a {
            margin: 0 10px;
            cursor: pointer;
            color: #555555;
        }
        li.active a {
            font-weight: bold;
        }
        li.next:before {
            content: ' | ';
            margin-right: 13px;
            color: #ddd;
        }
        li.disabled a {
            color: #ccc;
            cursor: no-drop;
        }
    }
    .price-up-items {
        display: flex;
        justify-content: flex-start;
        margin: 0px 10px;
        padding: 0px 15px;
        border-bottom: 1px solid black;
    }
    .price-up-item {
        font-size: 16px;
        padding: 3.5px 10px;
        margin-right: 10px; 
        border-right: 1px solid #e2e2e2;
        cursor: pointer;
        &:hover {
            background: #e2e2e2;
        }
        &:active {
            background: #c3c3c3;
        }
    }
    .prices-items {
        height: 180px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 3px solid black;
        margin: 1%;
        padding: 10px;
        cursor: pointer;
        position: relative;
        h2 {
            font-size: 20px;
        }
        span {
            padding: 0px 14px 3px 14px;
            border: 3px solid black;
            border-radius: 10px;
            position: absolute;
            bottom: 10px;
        }
    }
    .price-image {
        width: 80px;
        height: 80px;
    }
    
    @media (max-width: 991px) {
        .midle-price {
            margin-top: 69px;
        }
    }
    
    @media (max-width: 767px) {
        .col-sm-12 {
            flex: 0 0 100%;
        }
        .prices-items {
            flex: 0 0 60%;
            min-width: 160px;
        }
    }
    
    @media (max-width: 600px) {
        .price-up-item {
            padding: 5px;
            font-size: 15px;
        }
    }
    @media (max-width: 600px) and (max-height: 321px) {
        .price-items-pagination {
            height: 50px;
        }
        .price-image {
            width: 35%;
        }
        .prices-items span {
            font-size: 13px;
        }
        .prices-items {
            padding: 2px;
        }
        .prices-items {
            h2 {
                font-size: 17px;
            }
        }
    }

</style>


<template>
    <div class="midle-price" >
        <div class="price-up-items">
            <div class="price-up-item" v-on:click="(setPrise(1))">Tier 1</div>
            <div class="price-up-item" v-on:click="(setPrise(2))">Tier 2</div>
            <div class="price-up-item" v-on:click="(setPrise(3))">Tier 3</div>
            <div class="price-up-item" v-on:click="(setPrise(4))">Tier 4</div>
            <div class="price-up-item" v-on:click="(setPrise(5))">Tier 5</div>
        </div>
        <div class="container-fluid ">
            <div class="row flex-pos">
                <div v-for="(item) in pricesItems" class="col-xl-2 col-md-3 col-sm-12 prices-items" >
                    <h2>{{ item.mainText }}</h2>
                    <img class="price-image" v-bind:src="item.image" v-bind:alt="item.imageName" >
                    <span> $ {{ price }}</span>
                </div>
                
            </div>
        </div>
        <div class="price-items-pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
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
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                    
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                       
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                    {
                        mainText: "Text",
                        image:require('../../../../public/images/logodarck.png'),
                        imageName: "alt",
                        
                    },
                ]
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
    .midle-price {
        width: 75%;
        margin-left: 15%;
        margin-top: 111px;
    }
    .flex-pos {
        justify-content: center;
    }
    .price-up-items {
        display: flex;
        justify-content: flex-start;
        margin: 0px 10px;
        padding: 5px 15px;
        border-bottom: 1px solid black;
    }
    .price-up-item {
        font-size: 16px;
        padding: 5px 10px;
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
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 3px solid black;
        margin: 1%;
        padding: 10px;
        cursor: pointer;
        h2 {
            font-size: 20px;
        }
        span {
            margin-top: 5px;
            padding: 0px 14px 3px 14px;
            border: 3px solid black;
            border-radius: 10px;
        }
    }
    .price-image {
        width: 50%;
    }
    .price-items-pagination {
        display: flex;
        justify-content: center;
        position: fixed;
        bottom: 0%;
        height: 78px;
        background: #f7f7f7;
        padding-top: 1%;
        width: 70%;
        padding-top: 1%;
    }
    .page-link {
        color: black;
    }
    @media (max-width: 991px) {
        .midle-price {
            margin-top: 69px;
        }
    }
    
    @media (max-width: 767px) {
        .col-sm-12 {
            flex: 0 0 50%;
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


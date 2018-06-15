<template>
    <div class="midle-bag" >
        <div class="bag-up-items">
            <div class="bag-up-item">Link</div>
            <div class="bag-up-item">Link</div>
            <div class="bag-up-item">Link</div>
            <div class="bag-up-item">Link</div>
            <div class="bag-up-item">Link</div>
        </div>
        <div class="container-fluid ">
            <div class="row flex-pos">
                <div v-for="(item) in bagItems" class="col-xl-2 col-md-3 col-sm-12 bag-items" >
                    <img class="bag-image" v-bind:src="item.image" v-bind:alt="item.imageName" >
                    <h2>{{ item.mainText }}</h2>
                    <p> {{ item.downText }} </p>
                </div>
                
            </div>
        </div>
        <div class="bag-items-pagination">
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
                bagItems: [
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
                    }
                ]
            }
        },
        
    }
</script>
<style lang="scss">
    main {
            display: flex;
        }
    .midle-bag {
        width: 75%;
        
    }
    .flex-pos {
        justify-content: center;
    }
    .bag-up-items {
        display: flex;
        justify-content: flex-start;
        margin: 0px 10px;
        margin-bottom: 20px;
        padding: 5px 15px;
        border-bottom: 1px solid black;
    }
    .bag-up-item {
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
    .bag-items {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 1%;
        padding: 10px;
        cursor: pointer;
        h2 {
            font-size: 20px;
        }
        p {
            margin-top: 5px;
           
        }

    }
    .bag-image {
        width: 100%;
    }
    .bag-items-pagination {
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
    @media screen and (max-width: 758px)  {
        .bag-image {
            width: 50%;
        }
        .bag-items-pagination {
            height: 40px;
        }
        .bag-up-items {
            margin-bottom: 0;
            padding: 0;
        }
        .page-link {
            padding: 0.4rem 0.75rem;
        }
        
    }
    @media screen and (max-width: 740px)  {
        .bag-image {
            width: 50%;
        }
        .bag-items-pagination {
            height: 40px;
        }
        .bag-up-items {
            margin-bottom: 0;
            padding: 0;
        }
        .page-link {
            padding: 0.4rem 0.75rem;
        }
        
    }
    
    @media (min-width: 576px) {
        .col-sm-12 {
            flex: 0 0 50%;
        }
    }



</style>


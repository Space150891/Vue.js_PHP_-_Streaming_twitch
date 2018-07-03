<template>
    <div class="midle-bag" >
        <div class="scroll">
            <div class="bag-up-items">
                <div class="bag-up-item">Link</div>
                <div class="bag-up-item">Link</div>
                <div class="bag-up-item">Link</div>
                <div class="bag-up-item">Link</div>
                <div class="bag-up-item">Link</div>
            </div>
            <div class="container-fluid ">
                <!-- paginate -->
                <paginate name="bagItems" :per="10" :list="bagItems" class="row flex-pos">
                    <div v-for="(item) in paginated('bagItems')" class="col-lg-2 col-md-3 col-sm-4 col-12 bag-items" >
                        <img class="bag-image" v-bind:src="item.image" v-bind:alt="item.imageName" >
                        <h2>{{ item.mainText }}</h2>
                        <p> {{ item.downText }} </p>
                    </div>
                </paginate>
                <paginate-links for="bagItems" :limit="0" :show-step-links="true"></paginate-links>
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
                    }
                ],
                paginate: ['bagItems']
            }
        },
        
    }
</script>
<style lang="scss">
    body {
        overflow: hidden;
    }
    .midle-bag {
        width: 75%;
        height: 89vh;
        margin-left: 15%;
        margin-top: 109px;
        overflow-y: scroll;
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
        height: auto;
    }
    
    .paginate-links.bagItems {
        user-select: none;
        display: flex;
        justify-content: center;
        margin-top: 2%;
        margin-bottom: 6%;
        list-style-type: none;
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

    @media screen and (max-width: 991px)  {
        .midle-bag {
            margin-top: 69px;
        }
    }

    @media screen and (max-width: 758px)  {
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
    
    @media (max-width: 576px) {
        .bag-image {
            width: 75%;
        }
    }
    
</style>


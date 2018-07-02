<template>
    <div class="footer-part">
        <div class="footer-wrap">
            <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="../../../../public/images/footerImgFull.png" alt="footer-logo">
                        </div>
                        <div class="col-md-3">
                            <ul>
                                <li><a href="#">Help</a></li>
                                <li><a href="#">Support</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Packages</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            
        </div>
        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, nemo! <span>&copy; 2018</span></h3>
    </div>
</template>

<style lang="scss">
    .footer-part {
        width: 100%;
        height: auto;
        padding: 10px;
        padding-bottom: 5%;
        h3 {
            font-size: 12px;
            text-align: center;
            margin-top: 5px;
        }
    }
    ul {
        margin: 0;
        li {
            list-style: none;
            a {
                text-decoration: none;
                color: gray;
                &:hover {
                    text-decoration: none;
                    color: rgb(68, 67, 67);
                }
            }
        }
    }
    @media (max-height: 520px)  {
        .footer-part {
            padding-bottom: 10%;
        }
    }
    @media (max-height: 270px)  {
        .footer-part {
            padding-bottom: 13%;
        }
    }
</style>

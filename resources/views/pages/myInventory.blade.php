@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content area -->
    <div class="content">
        <!-- Rounded basic tabs -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Inventory</h6>
                        <div class="header-elements">
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-solid border-0">
                            <li class="nav-item"><a href="#streamcases" class="nav-link rounded-top active" data-toggle="tab">StreamCases</a></li>
                            <li class="nav-item"><a href="#prices" class="nav-link rounded-top" data-toggle="tab" id="prizes-but">Prices</a></li>
                            <li class="nav-item"><a href="#frames" class="nav-link rounded-top" data-toggle="tab"  id="frames-but">Frames</a></li>
                            <li class="nav-item"><a href="#artworks" class="nav-link rounded-top" data-toggle="tab" id="heroes-but">Artworks</a></li>
                            <li class="nav-item"><a href="#achievements" class="nav-link rounded-top" data-toggle="tab" id="achievements-but">Achievements</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="streamcases">
                                <!-- Left content -->
                                <div class="w-100 overflow-hidden">
                                    <!-- Grid -->
                                    <div class="row" id="streamcases-list">
                                    </div>
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center pt-3 mb-3 " id="streamcases-pagination">
                                        
                                    </div>
                                    <!-- /pagination -->
                                </div>
                            </div>

                            <div class="tab-pane fade" id="prices">
                                <!-- Left content -->
                                <div class="w-100 overflow-hidden">
                                    <!-- Grid -->
                                    <div class="row" id="prizes-list">
                                    </div>
                                    <!-- /grid -->
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center pt-3 mb-3" id="prizes-pagination">
                                    </div>
                                    <!-- /pagination -->
                                </div>
                                <!-- /left content -->
                            </div>

                            <div class="tab-pane fade" id="frames">
                                <!-- Left content -->
                                <div class="w-100 overflow-hidden">
                                    <!-- Grid -->
                                    <div class="row" id="frames-list">
                                    </div>
                                    <div class="d-flex justify-content-center pt-3 mb-3" id="frames-pagination">
                                    </div>
                                    <!-- /left content -->
                                </div>
                            </div>

                            <div class="tab-pane fade " id="artworks">
                                <!-- Left content -->
                                <div class="w-100 overflow-hidden">

                                    <!-- Grid -->
                                    <div class="row" id="heroes-list">

                                    </div>
                                    <!-- /grid -->

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center pt-3 mb-3" id="heroes-pagination">
                                    </div>
                                    <!-- /pagination -->

                                </div>
                                <!-- /left content -->
                            </div>

                            <div class="tab-pane fade " id="achievements">
                                <div class="row" id="achievements-list">
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center pt-3 mb-3" id="achievements-pagination">
                                </div>
                                <!-- /pagination -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->
</div>

<div id="modal_weel" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        
        <div class="modal-content" style="background-color:#333333">
            <div class="modal-header">
                <h5 class="modal-title text-white">Open <span id="will-box-name"></span> StreamCase</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="easyWheel ewnOhIUaLp" style="font-size: 20px; width: 400px; height: 400px;">
                    <div class="eWheel-wrapper" style="width: 400px; height: 400px; font-size: 100%;">
                        <div class="eWheel-inner">
                            <div class="eWheel" id="main-weel">
                                <div class="eWheel-bg-layer">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200" xml:space="preserve" style="enable-background:new 0 0 200 200;">
                                        <g class="ew-slicesGroup">
                                            <path stroke-width="0" fill="rgb(231, 76, 60)" data-fill="rgb(231, 76, 60)" d="M195.49636365262836,100.83338414009471 A95.5,95.5,0,0,1,148.46991366274725,182.2855848221657 L126.49596321166024,142.4024048078213 A50,50,0,0,0,149.96954135095478,101.74497483512505 z"></path>
                                            <path stroke-width="0" fill="rgb(231, 76, 60)" data-fill="rgb(231, 76, 60)" d="M147.02644998988112,183.11896896226042 A95.5,95.5,0,0,1,52.9735500101189,183.11896896226042 L76.52642186070547,144.14737964294636 A50,50,0,0,0,123.47357813929455,144.14737964294633 z"></path>
                                            <path stroke-width="0" fill="rgb(39, 174, 96)" data-fill="rgb(39, 174, 96)" d="M51.53008633725274,182.2855848221657 A95.5,95.5,0,0,1,4.503636347371639,100.83338414009475 L50.030458649045215,101.74497483512503 A50,50,0,0,0,73.50403678833976,142.4024048078213 z"></path>
                                            <path stroke-width="0" fill="rgb(241, 196, 15)" data-fill="rgb(241, 196, 15)" d="M4.503636347371639,99.1666158599053 A95.5,95.5,0,0,1,51.53008633725276,17.714415177834283 L73.50403678833975,57.5975951921787 A50,50,0,0,0,50.030458649045215,98.25502516487495 z"></path>
                                            <path stroke-width="0" fill="rgb(41, 128, 185)" data-fill="rgb(41, 128, 185)" d="M52.97355001011888,16.88103103773959 A95.5,95.5,0,0,1,147.0264499898811,16.881031037739575 L123.47357813929452,55.852620357053645 A50,50,0,0,0,76.52642186070545,55.85262035705365 z"></path>
                                            <path stroke-width="0" fill="rgb(46, 204, 113)" data-fill="rgb(46, 204, 113)" d="M148.46991366274727,17.71441517783431 A95.5,95.5,0,0,1,195.49636365262836,99.16661585990532 L149.96954135095478,98.25502516487497 A50,50,0,0,0,126.49596321166024,57.597595192178694 z"></path>
                                        </g>
                                        <radialGradient id="SVGID_1_" cx="50%" cy="50%" r="50%" gradientUnits="userSpaceOnUse">
                                            <stop offset="0.1676" style="stop-color:#000;stop-opacity:1"></stop>
                                            <stop offset="0.5551" style="stop-color:#000;stop-opacity:1"></stop>
                                            <stop offset="0.6189" style="stop-color:#000;stop-opacity:1"></stop>
                                            <stop offset="1" style="stop-color:#000;stop-opacity:0"></stop>
                                        </radialGradient>
                                        <circle cx="50%" cy="50%" r="50%" stroke-width="0" fill-opacity="0.3" fill="url(#SVGID_1_)"></circle>
                                        <g>
                                            <path stroke-width="0" fill="#424242" d="M146.73602414201483,183.28261551726752 A95.5,95.5,0,0,1,148.75684866055835,182.1158919375014 L126.6438138035365,142.3096583063782 A50,50,0,0,0,123.31933201699457,144.2290487607542 z"></path>
                                            <path stroke-width="0" fill="#424242" d="M51.24315133944166,182.11589193750143 A95.5,95.5,0,0,1,53.26397585798518,183.28261551726752 L76.68066798300543,144.2290487607542 A50,50,0,0,0,73.35618619646351,142.3096583063782 z"></path>
                                            <path stroke-width="0" fill="#424242" d="M4.50712719742684,98.83327642023394 A95.5,95.5,0,0,1,4.50712719742684,101.16672357976613 L50.03685417946894,101.919390454376 A50,50,0,0,0,50.03685417946894,98.08060954562401 z"></path>
                                            <path stroke-width="0" fill="#424242" d="M53.26397585798516,16.7173844827325 A95.5,95.5,0,0,1,51.24315133944168,17.88410806249857 L73.35618619646351,57.6903416936218 A50,50,0,0,0,76.68066798300543,55.77095123924581 z"></path>
                                            <path stroke-width="0" fill="#424242" d="M148.75684866055838,17.884108062498598 A95.5,95.5,0,0,1,146.7360241420148,16.717384482732484 L123.31933201699455,55.7709512392458 A50,50,0,0,0,126.64381380353647,57.69034169362178 z"></path>
                                            <path stroke-width="0" fill="#424242" d="M195.49287280257317,101.16672357976601 A95.5,95.5,0,0,1,195.49287280257317,98.83327642023394 L149.96314582053105,98.08060954562401 A50,50,0,0,0,149.96314582053105,101.919390454376 z"></path>
                                        </g>
                                        <circle class="centerCircle" cx="100" cy="100" r="51" stroke="#424242" stroke-width="4" fill="#333333"></circle><circle cx="100" cy="100" r="97.5" stroke="#424242" stroke-width="5" fill-opacity="0" fill="#fff0"></circle>
                                    </svg>
                                </div>
                                <div class="eWheel-txt-wrap">
                                    <div class="eWheel-txt" style="transform: rotate(30deg);">
                                        <div class="eWheel-title" style="padding-right: 6%; transform: rotate(0deg) translate(0px, -50%); color: rgb(255, 255, 255);"><span id="will-box-points">10.000</span> <i class="icon-cube3" mr-2=""></i><div>
                                    </div>
                                </div>
                                <div class="eWheel-title" style="padding-right: 6%; transform: rotate(60deg) translate(0px, -50%); color: rgb(255, 255, 255);"><span id="will-box-diamonds"></span> <i class="icon-diamond" mr-2=""></i></div>
                                <div class="eWheel-title" style="padding-right: 6%; transform: rotate(120deg) translate(0px, -50%); color: rgb(255, 255, 255);"><span id="will-box-hero"></span><br> Artwork</div>
                                <div class="eWheel-title" style="padding-right: 6%; transform: rotate(180deg) translate(0px, -50%); color: rgb(255, 255, 255);"><span id="will-box-frame"></span><br> Frame</div>
                                <div class="eWheel-title" style="padding-right: 6%; transform: rotate(240deg) translate(0px, -50%); color: rgb(255, 255, 255);">Prize <span id="will-box-prize"></span> $</div>
                                <div class="eWheel-title" style="padding-right: 6%; transform: rotate(300deg) translate(0px, -50%); color: rgb(255, 255, 255);">no win</div>
                                
                            </div>
                        </div>
                        <div class="eWheel-center" id="will-box-image"></div>
                    </div>
                </div>
                <div class="eWheel-marker">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 80 115" style="enable-background:new 0 0 80 115;" xml:space="preserve">
                        <g>
                            <path fill="rgb(192, 57, 43)" d="M40,0C17.9,0,0,17.7,0,39.4S40,115,40,115s40-53.9,40-75.6S62.1,0,40,0z M40,52.5c-7,0-12.6-5.6-12.6-12.4 S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"></path>
                            <path fill="rgba(0, 0, 0, 0.3)" d="M40,19.2c-11.7,0-21.2,9.3-21.2,20.8S28.3,60.8,40,60.8S61.2,51.5,61.2,40S51.7,19.2,40,19.2z M40,52.5 c-7,0-12.6-5.6-12.6-12.4S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <h2 class="easyWheel-message text-center text-white">&nbsp;</h2>

            </div>

            <div class="modal-footer">

                <button class="btn bg-green-800 btn-labeled btn-labeled-left spin-button" id="will-spin-but"><b><i class="icon-spinner4"></i></b>Spin</button>
                <!-- <a href="https://streamcases.tv/profile/dlausch/redeem/1847782873" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left redeem-button" style="display:none;"><b><i class="icon-cart"></i></b>Redeem</a> -->
                
                <button class="btn bg-danger-800 btn-labeled btn-labeled-left" data-dismiss="modal"><b><i class="icon-close2"></i></b>Close</button>

            </div>
        </div>
    </div>
</div>
</div>

<div id="modal-box-details" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="box-history-name"></span> StreamCase win</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="box-history-details">
                
            </div>

            <div class="modal-footer">

                <button class="btn bg-danger-800 btn-labeled btn-labeled-left" data-dismiss="modal"><b><i class="icon-close2"></i></b>Close</button>

            </div>
        </div>
    </div>
</div>

@endsection
<script>
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/myInventory.js')}}"></script>
@endsection
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
        <meta name="description" content="">
        <link rel="shortcut icon" href="/favicon.ico">
        {{-- Global stylesheets --}}
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap_limitless.css" rel="stylesheet" type="text/css">
        <link href="assets/css/layout.css" rel="stylesheet" type="text/css">
        <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/easywheel.css" rel="stylesheet" type="text/css">
        <link href="assets/css/cookiealert.css" rel="stylesheet" type="text/css">


        {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
            <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
        <![endif]-->

        {{-- Main JS Block -- }}
        {{-- Core JS files --}}
            <script src="global_assets/js/main/jquery.min.js"></script>
            <script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
            <script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
        {{-- Theme JS files --}}
            <script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
            <script src="global_assets/js/plugins/ui/prism.min.js"></script>
            <script src="global_assets/js/plugins/media/fancybox.min.js"></script>
            <script src="global_assets/js/plugins/notifications/bootbox.min.js"></script>
            <script src="assets/js/components_popups.js"></script>
            <script src="global_assets/js/demo_pages/components_modals.js"></script>
            <script src="global_assets/js/plugins/loaders/progressbar.min.js"></script>
            <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
            <script src="assets/js/app.js"></script>
        {{-- DEV INFO ALL JS AFTER HERE GETS EXECUTED AFTER PAGE COMPLETELY LOADED BY APP.JS BEFORE --}}
            <script src="assets/js/components_progress.js"></script>
        {{-- Perfect Scollbar --}}
            <script src="global_assets/js/plugins/ui/perfect_scrollbar.min.js"></script>
        {{-- FETCH --}}
            <script src="js/fetch/mainFetch.js"></script>
        {{-- Pages js --}}
            <script src="js/streamPage/streamMain.js"></script>

        <script>

            var pageUrl = window.location.pathname;
            if(pageUrl == "/twitch/callback") {
                @if (isset($access_token))
                    window.access_token = "{{($access_token)}}";
                    window.twitch_refresh_token = "{{($twitch_refresh_token)}}";
                @endif
                localStorage.setItem('userToken', window.access_token);
                localStorage.setItem('twitchRefresh', window.twitch_refresh_token);
                // window.location.replace("http://localhost:8081/");
                window.location = '/';
            }

        </script>
    </head>
    <body class="navbar-bottom navbar-top sidebar-right-visible">
    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="navbar-brand">
            <a href="index.html" class="d-inline-block">
                <img src="assets/images/logo_sc_mini.png" alt="">
            </a>
        </div>
        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-transmission"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-right-toggle" type="button">
                <i class="icon-transmission"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-component-toggle" type="button">
                <i class="icon-bubble2"></i>
            </button>
            <button class="navbar-toggler" onclick="fullscreen()" type="button">
                <i class="icon-screen-full"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="directory.html" class="navbar-nav-link navbar-font-size">
                        Directory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="prices.html" class="navbar-nav-link navbar-font-size">
                        Prices
                    </a>
                </li>
                <li class="nav-item">
                    <a href="store" class="navbar-nav-link navbar-font-size">
                        Store
                    </a>
                </li>
            </ul>
            <span class="navbar-text ml-md-3 mr-md-auto badge bg-danger-800 d-none d-md-block">
               <a href="upgrade">
               <span class="font-size-sm font-weight-bold">Promote your Channel</span>
			</a>
			</span>
            <ul class="navbar-nav auth-user">

            </ul>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a> Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Main navigation -->
                <div class="card card-sidebar-mobile ">
                    <ul class="nav nav-sidebar " data-nav-type="accordion ">

                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link sidebar-control sidebar-main-toggle ">
                                                            <i class="icon-paragraph-justify3"></i>
                                                        </a>
                        </li> -->

                        <!-- Promoted streamer -->

                        <li class="nav-item">
                            <a class="nav-link navbar-toggler sidebar-main-toggle ">
                                <i class="icon-transmission"></i>

                            </a>
                        </li>

                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Promoted Channels</div> <i class="icon-video-camera2" title="Promoted Channels"></i>
                        </li>
                    </ul>
                    <ul class="nav nav-sidebar  promoted-data" data-nav-type="accordion ">

                    </ul>


                        <!-- /Promoted streamer -->
                        <!-- Following list online -->
                    <div class="following-items-part" style="display: none">
                        <ul class="nav nav-sidebar" data-nav-type="accordion ">
                            <li class="nav-item-header">
                                <div class="text-uppercase font-size-xs line-height-xs">Following (Live)</div> <i class="icon-heart5" title="Following (Online)"></i>
                            </li>
                        </ul>
                        <ul class="nav nav-sidebar following-online-data" data-nav-type="accordion ">
                        </ul>


                            <!-- /Following list online -->
                            <!-- Following list offline -->
                        <ul class="nav nav-sidebar " data-nav-type="accordion ">
                            <li class="nav-item-header">
                                <div class="text-uppercase font-size-xs line-height-xs">Following (Offline)</div> <i class="icon-heart-broken2" title="Following (Offline)"></i>
                            </li>
                        </ul>
                        <ul class="nav nav-sidebar following-offline-data" data-nav-type="accordion ">
                        </ul>
                    </div>

                        <!-- /Following list offline -->
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->

            @yield('content')


        <!-- Right sidebar -->
        <div class="sidebar sidebar-fixed sidebar-dark sidebar-right sidebar-expand-md">
            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
                <span class="font-weight-semibold">Right sidebar</span>
                <a href="#" class="sidebar-mobile-right-toggle">
                    <i class="icon-arrow-right8"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->
            <!-- Sidebar content -->


            <div class="sidebar-content ">
                <!-- Main navigation -->
                <div class="card card-sidebar-mobile ">
                    <ul class="nav nav-sidebar " data-nav-type="accordion ">


                        <!-- Loot Feed - PoC! -->


                        <li class="nav-item ">
                            <a class="nav-link justify-content-center pr-0 ">
                                <i class="icon-cabinet "></i>



                            </a>
                        </li>

                        <!-- DEV INFO - THIS IS JUST POC. YOU SHOULD NOT USE THIS CRAP ON PRODUCTION ENV -->

                        <div class="feedcontainer ">
                            <li><img src="assets/images/StreamCases/rare.png " height="64 " alt=" " data-popup="popover-custom " data-placement="left " title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'>
																	DLausch" data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/uncommon.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/rare.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/legendary.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/rare.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/uncommon.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/rare.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/legendary.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>

                            <li><img src="assets/images/StreamCases/rare.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/common.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/uncommon.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/epic.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/rare.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>
                            <li><img src="assets/images/StreamCases/legendary.png" height="64" alt="" data-popup="popover-custom" data-placement="left" title="<img src='https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg' height='32'> DLausch"
                                     data-html="true" id="popover-hide" data-trigger="hover" data-content="<b>Won></b> a Headset worth <b>120$</b>"></li>

                        </div>
                        <script>
                            var x = 0,
                                container = $('.feedcontainer'),
                                items = container.find('li'),
                                containerHeight = 0,
                                numberVisible = 50,
                                intervalSec = 2000;

                            if (!container.find('li:first').hasClass("first")) {
                                container.find('li:first').addClass("first");
                            }

                            items.each(function() {
                                if (x < numberVisible) {
                                    containerHeight = containerHeight + $(this).outerHeight();
                                    x++;
                                }
                            });

                            container.css({
                                height: containerHeight,
                                overflow: "hidden"
                            });

                            function vertCycle() {
                                var firstItem = container.find('li.first').html();

                                container.append('<li>' + firstItem + '</li>');
                                firstItem = '';
                                container.find('li.first').animate({
                                    marginTop: "-53.5px"
                                }, 600, function() {
                                    $(this).remove();
                                    container.find('li:first').addClass("first");
                                });
                            }

                            if (intervalSec < 700) {
                                intervalSec = 700;
                            }

                            var init = setInterval("vertCycle()", intervalSec);

                            container.hover(function() {
                                clearInterval(init);
                            }, function() {
                                init = setInterval("vertCycle()", intervalSec);
                            });
                        </script>


                        <!-- Loot Feed - PoC! -->

                </div>

                <!-- hardcoded-fix-distance-from-bottom -->
                <li class="media ">
                    &nbsp;
                </li>
                <!-- /hardcoded-fix-distance-from-bottom -->

                </ul>
                <!-- /main navigation -->
            </div>


        </div>
        <!-- /right sidebar -->

        <!-- /page content -->


        <!-- Basic modal -->
        <!-- <div id="modal_ref" class="modal fade " tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header bg-teal">
                        <h5 class="modal-title">Invite your friends and earn extra Credits!</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h6 class="font-weight-semibold">How it works?</h6>
                        <p>Refer your friends using the code below and you will earn one extra Credit per Minute for each refered friend that is earning Credits in the same time as you.
                        </p>

                        <hr>
                        <div class="row">
                            <div class="col-sm-10">
                                <h6 class="font-weight-semibold">Your Referal Link:</h6>
                                <p>
                                    <input id="reflink" type="text"  onfocus="this.select();" onmouseup="return false;"  value="https://streamcases.tv/?ref=12345" class="form-control" readonly>
                                </p>
                            </div>

                            <div class="col-sm-2 d-none d-md-block">

                                <h6 class="font-weight-semibold">&nbsp;</h6>
                                <p>
                                    <i class="icon-clipboard mr-3 icon-2x" 	onclick="copyClip()"></i> </p>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn bg-primary">Learn more</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    </div>

                    <script>
                        function copyClip() {
                          var copyText = document.getElementById("reflink");
                      copyText.select();
                  document.execCommand("copy");
                     }
                    </script>
                </div>
            </div>
        </div> -->
        <!-- /basic modal -->


        <!-- Perfect Scollbar -->
        <script>
            var ps1 = new PerfectScrollbar('.sidebar-main .sidebar-content', {
                wheelSpeed: 1,
                wheelPropagation: true
            });

            var ps2 = new PerfectScrollbar('.sidebar-right .sidebar-content', {
                wheelSpeed: 1,
                wheelPropagation: true

            });
        </script>
        <!-- /Perfect Scollbar -->

        <!-- Stream & chat resize -->
        <script>


            $(".sidebar-main-toggle").on("click", function(){
                if ($(window).width() > 767) {
                    setTimeout(function(){
                        $('#chat').height($('.stream').height());
                        $('.sidebar-component-right').height($('.stream').height());
                    }, 100);
                }

            });

            $( document ).ready(function() {
                $('#chat').height($('.stream').height());
                $('.sidebar-component-right').height($('.stream').height());
            });

            $(window).resize(function() {
                $('.sidebar-component-right').width('22.5rem');
                $('#chat').width('22.5rem');

                $('.sidebar-component-right').height($('.stream').height());
                $('#chat').height($('.stream').height());

                if ($(window).width() < 768) {

                    $('#chat').height(300);
                    $('.sidebar-component-right').height(300);

                    $('.sidebar-component-right').width($('.stream').width());

                    $('#chat').width($('.sidebar-component-right').width());


                }

                else if ($(window).width() < 1201) {

                    $('.sidebar-component-right').width('15rem');

                    $('#chat').width('15rem');

                    $('.sidebar-component-right').height($('.stream').height());
                    $('#chat').height($('.sidebar-component-right').height());


                }


                else if ($(window).width() < 1367) {

                    $('#chat').width('18.75rem');
                    $('.sidebar-component-right').width('18.75rem');

                    $('.sidebar-component-right').height($('.stream').height());
                    $('#chat').height($('.sidebar-component-right').height());


                }


                if ($(window).height() < 361) {
                    $('.sidebar-component-right').height(280);
                    $('#chat').height(280);
                    $('.sidebar-component-right').width($('.stream').width());
                    $('#chat').width($('.stream').width());

                }

            });

            $(window).trigger('resize');

        </script>
        <!-- /Stream & chat resize -->

        <!-- Bottom navbar -->
        <div class="navbar navbar-expand-md navbar-dark fixed-bottom">
            <div class="text-center d-md-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-second">
                    <!-- <i class="icon-menu mr-2"></i> -->
                    &copy; 2018 StreamCases.tv - Closed test - (Preview and testing)
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-second">
				<span class="navbar-text d-none d-md-block">
						&copy; 2018 StreamCases.tv - Closed test - (Preview and testing)
					</span>

                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item"><a href="#" class="navbar-nav-link">About</a></li>
                    <li class="nav-item"><a href="#" class="navbar-nav-link">Support</a></li>


                </ul>

                <ul class="list-inline list-inline-condensed mb-0">
                    <li class="list-inline-item"><a href="http://twitch.tv/streamcases" target="_blank"> <img src="assets/images/SuperTinyIcons/svg/twitch.svg" height="20" title="Twitch"></a>
                        <!-- <li class="list-inline-item"><a href="http://youtube.com/" target="_blank"> <img src="assets/images/SuperTinyIcons/svg/youtube.svg" height="20" title="YouTube"></a> -->
                    <li class="list-inline-item"><a href="http://twitter.com/streamcases" target="_blank"> <img src="assets/images/SuperTinyIcons/svg/twitter.svg" height="20" title="Twitter"></a>

                </ul>
            </div>
        </div>
        <!-- /bottom navbar -->

        <!-- COOKIES ALERT -->
        <div class="alert cookiealert text-center" role="alert">
            This site uses cookies. By continuing to browse the site you are agreeing to our use of cookies.
            <br>
            <button type="button" class="btn btn-primary bg-teal acceptcookies" aria-label="Close">OK, I agree</button>
            <a href="cookies.html" target="_blank">
                <button type="button" class="btn btn-primary bg-danger-800" aria-label="Close">No, give me more info</button>
            </a>
        </div>
        <script>
            let elemСookiealert = document.getElementsByClassName('cookiealert')[0];
            setTimeout(function () {
                elemСookiealert.classList.add('show');
            }, 1950)

        </script>
        <!-- /COOKIES ALERT -->

        {{-- Pages js --}}
        <script src="js/streamPage/streamMain.js"></script>


    </body>
</html>

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{--<script src='https://www.google.com/recaptcha/api.js'></script>--}}
        {{--<script src="https://checkout.stripe.com/checkout.js"></script>--}}
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



        {{-- Fonts --}}
        {{--@yield('template_linked_fonts')--}}

        {{-- Styles --}}
        {{--<link href="{{ mix('/css/app.css') }}" rel="stylesheet">--}}

        {{--@yield('template_linked_css')--}}


        {{--@yield('head')--}}
        {{--@yield('header_scripts')--}}

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
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-stats-growth"></i>
                        <span class="badge badge-pill bg-danger-800 position-static ml-auto ml-md-1"></span>
                    </a>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">You currenctly earn 630 Credits per Minute!</span>
                        </div>
                        <!-- <div class="dropdown-content-body dropdown-scrollable custom-scrollbar"> -->
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Viewcount: </span>
                                            <span class="text-muted font-size-sm">200</span>

                                        </div>
                                        <span class="text-muted">Based on the viewer count of this Channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Type: </span>
                                            <span class="text-muted font-size-sm">20</span>
                                        </div>
                                        <span class="text-muted">Based on the account Type of this Channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Subscribe: </span>
                                            <span class="text-muted font-size-sm">10</span>
                                        </div>
                                        <span class="text-muted">Subscribed with a "Tier 2 Sub" to this channel.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Donation: </span>
                                            <span class="text-muted font-size-sm">50</span>
                                        </div>
                                        <span class="text-muted">Because you donated 50$ to this channel.<p><b>INFO FOR DEV: You get direct 10 Credits per CENT when donating as reward so like 10 euro = 10000 credits!</b></p></span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Promoted: </span>
                                            <span class="text-muted font-size-sm">100</span>
                                        </div>
                                        <span class="text-muted">This channel is currenctly in promoted state.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">
                                            <span class="font-weight-semibold">Affiliate: </span>
                                            <span class="text-muted font-size-sm">250</span>
                                        </div>
                                        <span class="text-muted">You earn extra Credits for your refered Viewers that are currenctly farming Credits.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-cube3"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Buy StreamCases</span>
                            <i class="icon-cube3"></i>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/common.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="" data-toggle="modal" data-target="#modal_iconified">
                                                <span class="font-weight-semibold">Common StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/uncommon.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Uncommon StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/rare.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Rare StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/epic.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Epic StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/legendary.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Legendary StreamCase</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Store"><i class="icon-store d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-diamond"></i>
                        <span class="badge badge-pill bg-teal-800 position-static ml-auto ml-md-1"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Buy Diamonds</span>
                            <i class="icon-diamond"></i>
                        </div>
                        <!-- <div class="dropdown-content-body dropdown-scrollable custom-scrollbar"> -->
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/gold_xxx.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Gold Pack</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="assets/images/StreamCases/gold_xxx.png" height="64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Gold Pack</span>
                                                <span class="text-muted float-right font-size-sm">5000</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">The most cool Case ever. Can make you damn rich!</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Store"><i class="icon-store d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-bubbles4"></i>
                        <span class="d-md-none ml-2">Notifications</span>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Notifications</span>
                            <a href="#" class="text-default"><i class="icon-compose"></i></a>
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Achievement Unlocked</span>
                                                <span class="text-muted float-right font-size-sm">04:58</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">Speak about StreamCases.tv</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Level up!</span>
                                                <span class="text-muted float-right font-size-sm">12:16</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">You reached Level 12</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Jeremy Victorino</span>
                                                <span class="text-muted float-right font-size-sm">22:48</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Beatrix Diaz</span>
                                                <span class="text-muted float-right font-size-sm">Tue</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="mr-3">
                                        <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Richard Vango</span>
                                                <span class="text-muted float-right font-size-sm">Mon</span>
                                            </a>
                                        </div>
                                        <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="All notifications"><i class="icon-newspaper d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <!-- If User is logged in -->
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/dlausch-profile_image-66f5f33b0872138a-70x70.jpeg" height="32" class="rounded-circle" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/profile/dlausch/index.html" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
                        <a href="/profile/dlausch/inventory.html" class="dropdown-item"><i class="icon-file-text2"></i> Inventory</a>
                        <!-- If User is Viewer (FREE) -->
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Account Type:	&nbsp;	</i> <span class="badge bg-danger font-size-sm font-weight-bold position-static ml-auto"> Viewer </span></a>
                        <a href="#" class="dropdown-item">Level:	&nbsp;	</i> <span class="badge bg-success font-size-sm font-weight-bold position-static ml-auto "> 12 </span></a>
                        <div class="dropdown-divider"></div>
                        <a href="upgrade" class="row justify-content-center p-0 text-center"><span class="badge bg-danger font-size-sm font-weight-bold">Upgrade to Streamer</span></a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="row justify-content-center p-0 text-center" ><span class="badge bg-success-800 font-size-sm font-weight-bold" data-toggle="modal" data-target="#modal_ref">Referal Link</span></a>
                        <div class="dropdown-divider"></div>
                        <a href="profile/dlausch/index.html" class="dropdown-item "><i class="icon-cog5 "></i> Account</a>
                        <a href="logout" class="dropdown-item "><i class="icon-switch2 "></i> Logout</a>
                    </div>
                </li>
                <li class="nav-item">
                    &nbsp;
                </li>
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

                        <li class="nav-item">
                            <a href="changelog.html" class="nav-link">
                                <i>
                                    <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" ">
                                </i>
                                <span class="truncate">
										Ur2EzTv_XXXXXXXXXXXXXXXXX
										<span class="d-block font-weight-normal opacity-50 truncate">The Walking Dead: The Final Season</span>
                                </span>

                                <span class="ml-3 align-self-center ">
                                    <span class="badge bg-success text-default badge-pill ml-auto ">850</span>
                                </span>
                            </a>
                        </li>


                        <!-- /Promoted streamer -->
                        <!-- Following list online -->
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Following (Live)</div> <i class="icon-heart5" title="Following (Online)"></i>
                        </li>

                        <li class="nav-item">
                            <a href="changelog.html" class="nav-link">
                                <i>  <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" "></i>
                                <span class="truncate">
										Ur2EzTv_XXXXXXXXXXXXXXXXX
										<span class="d-block font-weight-normal opacity-50 truncate">The Walking Dead: The Final Season</span>
                                </span>

                                <span class="ml-3 align-self-center ">
																			<span class="badge bg-danger text-default badge-pill ml-auto ">180</span>
                                </span>
                            </a>
                        </li>


                        <!-- /Following list online -->
                        <!-- Following list offline -->
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Following (Offline)</div> <i class="icon-heart-broken2" title="Following (Offline)"></i>
                        </li>

                        <li class="nav-item">
                            <a href="changelog.html" class="nav-link">
                                <i>  <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/6d942669-203f-464d-8623-db376ff971e0-profile_image-70x70.png " width="32 " height="32 " class="rounded-circle " alt=" "></i>
                                <span class="truncate">
										Ur2EzTv
										<span class="d-block font-weight-normal opacity-50 truncate">The Walking Dead: The Final Season</span>
                                </span>

                                <span class="ml-3 align-self-center ">

                                </span>
                            </a>
                        </li>
                    </ul>

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
            let elem = document.getElementsByClassName('cookiealert')[0];
            setTimeout(function () {
                elem.classList.add('show');
            }, 1950)

        </script>
        <!-- /COOKIES ALERT -->



        {{--@yield('footer_scripts')--}}
    </body>
</html>

@extends('layouts.app')

@section('content')
<div class="content-wrapper">


    <!-- Cover area -->
    <div class="profile-cover" id="profile-cover">
        <div class="profile-cover-img" style="background-image: url(https://static-cdn.jtvnw.net/jtv_user_pictures/ce34a7d2-4819-47a1-b7a5-f019d456f5db-profile_banner-480.png)">
        </div>
        <!-- DEV INFO if no cover image then global_assets/images/background/user_bg.jpg -->
        <div class="media align-items-center text-center text-md-left flex-column flex-md-row m-0">
            <div class="mr-md-3 mb-2 mb-md-0">
                <a href="#" class="profile-thumb">
                    <img src="https://static-cdn.jtvnw.net/jtv_user_pictures/086a13ac-9237-4605-bcd1-41ce1f79e764-profile_image-300x300.png" class="border-white rounded-circle" width="48" height="48" alt="">
                </a>
            </div>

            <div class="media-body text-white">
                <h1 class="mb-0" id="viewer-name"></h1>
                <span class="d-block" id="viewer-bio"></span>
            </div>

            <div class="ml-md-3 mt-2 mt-md-0">
                <ul class="list-inline list-inline-condensed mb-0">
                    <li class="list-inline-item"><a href="#" class="btn btn-light border-transparent" id="change-cover"><i class="icon-file-picture mr-2"></i> Cover image</a></li>
                </ul>
                <input type="file" id="file-upload" style="display:none">
            </div>
        </div>
    </div>
    <!-- /cover area -->

    <!-- Profile navigation -->
    <div class="navbar navbar-expand-lg navbar-light bg-light" id="navbar-profile" style="display:block">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-second">
                <i class="icon-menu7 mr-2"></i>
                Profile navigation
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-second">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="#account" class="navbar-nav-link active" data-toggle="tab">
                        <i class="icon-menu7 mr-2"></i>
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#profile" class="navbar-nav-link" data-toggle="tab">
                        <i class="icon-profile mr-2"></i>
                        Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#follower" class="navbar-nav-link" data-toggle="tab">
                        <i class="icon-user mr-2"></i>
                        Follower
                        <span class="badge badge-pill bg-success position-static ml-auto ml-lg-2" id="follower-count"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#following" class="navbar-nav-link" data-toggle="tab">
                        <i class="icon-heart5 mr-2"></i>
                        Following
                        <span class="badge badge-pill bg-success position-static ml-auto ml-lg-2" id="following-count"></span>
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item">
                    <a href="/profile/dlausch/dashboard.html" class="navbar-nav-link">
                        <i class="icon-newspaper mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{asset('my-inventory')}}" class="navbar-nav-link">
                        <i class="icon-file-text2 mr-2"></i>
                        Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/profile/dlausch/gamecards.html" class="navbar-nav-link">
                        <i class="icon-profile mr-2"></i>
                        Game Cards
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-gear"></i>
                        <span class="d-lg-none ml-2">Settings</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a href="/profile/dlausch/notifications.html" class="dropdown-item"><i class="icon-bubble2"></i> Notifications</a>

                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /profile navigation -->
    <!-- Content area -->
    <div class="content">

        <!-- Inner container -->
        <div class="d-flex align-items-start flex-column flex-md-row">

            <!-- Left content -->
            <div class="tab-content w-100 order-2 order-md-1">

                <div class="tab-pane fade active show" id="account">

                    <div class="card">
                        <div class="card-body" id="accaunt-abilities-list">
                            <h5 class="card-title">
                                                    <a href="#" class="text-default">

                                                        Account overview
                                                    </a>
                                                </h5>

                            <p class="mb-3">You have a Gold account. You are able to upgrade your Account to gain more features!</p>

                            <ul class="list list-unstyled mb-0">
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> 10 Credits per Minute
                                </li>
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> 20 Credits per Minute
                                </li>
                                <li>
                                    <i class="icon-checkmark-circle text-success mr-2"></i> 50 Credits per Minute
                                </li>
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> 100 Credits per Minute
                                </li>
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> 200 Credits per Minute
                                </li>
                                <li>
                                    <i class="icon-checkmark-circle text-success mr-2"></i> Custom Donation Page
                                </li>
                                <li>
                                    <i class="icon-checkmark-circle text-success mr-2"></i> Own Achievement
                                </li>
                                <li>
                                    <i class="icon-checkmark-circle text-success mr-2"></i> Own Rare Artwork
                                </li>
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> Own Epic Artwork
                                </li>
                                <li>
                                    <i class="icon-circle text-danger mr-2"></i> Own Legendary Artwork
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /account info PAID -->

                    <!-- Profile info -->
                    <div class="card">


                        <div class="card-body">

                            <h5 class="card-title">Account information</h5>
                            <p class="mb-3">In order to become able to farm coins or to win free prices you must verify your phone #. Other details will be used in case of shipping</p>

                            <form action="#">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Username</label>
                                            <input type="text" class="form-control" id="contact-name">
                                        </div>
                                            <div class="col-md-6">
                                                <label>Full name</label>
                                                <input type="text" value="Kopyov" class="form-control" id="contact-full-name">
                                        </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Address line 1</label>
                                                    <input type="text" class="form-control" id="contact-address-1">
                                        </div>
                                                    <div class="col-md-6">
                                                        <label>Address line 2</label>
                                                        <input type="text" class="form-control"  id="contact-address-2">
                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Your country</label>
                                                            <select class="form-control form-control-select2" id="countries-select">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>City</label>
                                                            <input type="text" class="form-control"  id="contact-city">
                                        </div>
                                                            <div class="col-md-3">
                                                                <label>State/Province</label>
                                                                <input type="text" class="form-control"  id="contact-state">
                                        </div>
                                                                <div class="col-md-3">
                                                                    <label>ZIP code</label>
                                                                    <input type="text" class="form-control"  id="contact-zip">
                                        </div>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Phone #</label>
                                                                        <input type="text" class="form-control" id='contact-phone'>
                                                                        <span class="form-text text-muted">Example: +99123456789</span>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>Verify #</label>
                                                                        <div class="col-md-6" id="verify-block">
                                                                            <!-- <input type="text" class="btn btn-danger" placeholder="code from sms..." aria-label="code from sms..." aria-describedby="check-sms-but" id="sms-code"> -->
                                                                            <button class="btn btn-danger"  id="sms-code">verify</button>
                                                                        </div>
                                                                        <span class="form-text text-muted">To reduce the riscs of bots you have to verify your Account to become able to redeem prices!</span>

                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class="text-right">
                                                                <button class="btn btn-primary" id="save-contacts">Save changes</button>
                                                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- /profile info -->


                </div>

                <div class="tab-pane fade" id="profile">


                    <!-- Profile info -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Social	</h5>

                        </div>

                        <div class="card-body">
                            <form action="#">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Twitch</label>
                                            <input type="text" value="https://twitch.tv/ninja" class="form-control" id="social-twitch">
                                        </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>YouTube</label>
                                                <input type="text" value="https://www.youtube.com/user/dawg2k7" class="form-control"  id="social-youtube">
                                        </div>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Twitter</label>
                                                    <input type="text" value="https://twitter.com/ninja" class="form-control" id="social-twitter">

                                        </div>


                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Instagram</label>
                                                        <input type="text" value="https://www.instagram.com/ninja/" class="form-control"  id="social-instagram">

                                        </div>


                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button class="btn btn-primary" id="save-social">Save changes</button>
                                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /profile info -->


                </div>


                <div class="tab-pane fade" id="follower">
                    <!-- Rounded thumbs -->


                    <div class="row" id="follower-list">
                    
                    </div>

                    <!-- /rounded thumbs-->
                </div>

                <div class="tab-pane fade" id="following">
                    <!-- Rounded thumbs -->
                    <div class="row" id="following-list">
                    </div>

                    <!-- /rounded thumbs-->
                </div>


            </div>
            <!-- /left content -->


        </div>
        <!-- /inner container -->

    </div>
    <!-- /content area -->
</div>

@endsection
<script>
    
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/cabinet.js')}}"></script>
@endsection
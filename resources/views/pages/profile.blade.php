@extends('layouts.app')

@section('content')

<!-- Main content -->
<div class="content-wrapper">


<!-- Cover area -->
<div class="profile-cover" id="profile-cover">
    <div class="profile-cover-img" style="background-image: url(https://static-cdn.jtvnw.net/jtv_user_pictures/ce34a7d2-4819-47a1-b7a5-f019d456f5db-profile_banner-480.png)"></div>
    <!-- DEV INFO if no cover image then global_assets/images/background/user_bg.jpg -->
    <div class="media align-items-center text-center text-md-left flex-column flex-md-row m-0">
        <div class="mr-md-3 mb-2 mb-md-0" id="user-avatar">
            
        </div>

        <div class="media-body text-white">
            <h1 class="mb-0" id="viewer-name">Ur2EzTv</h1>
            <span class="d-block" id="viewer-bio">DEV INFO THATS BIO! Stream returns Tuesday | !merch | Follow my socials @EZZZ</span>
        </div>


    </div>
</div>
<!-- /cover area -->


<!-- Profile navigation -->
<div class="navbar navbar-expand-lg navbar-light bg-light" style="display:block">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-second">
            <i class="icon-menu7 mr-2"></i>
            Profile navigation
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-second">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a href="#profile" class="navbar-nav-link active" data-toggle="tab">
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

        <ul class="navbar-nav ml-lg-auto" id="profile-buttons">
            
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


            <div class="tab-pane fade active show" id="profile">


                <!-- Account info FREE -->

                <div class="card">

                    <div class="card-footer">
                        <ul class="list-inline list-inline-condensed mb-0" id="social-list">
                        </ul>
                    </div>

                </div>
                <!-- /account info FREE -->


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
<!-- /main content -->

@endsection
<script>
    const viewerName = "{{ $viewerName }}";
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/profile.js')}}"></script>
@endsection
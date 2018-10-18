@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<!-- Content area -->
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Directory</h6>
                    </div>
                    <div class="card-body">
                        <!-- Cards in grid columns -->
                        <div class="row" id="streamers-by-game">

                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <img class="card-img-top img-fluid" src="https://static-cdn.jtvnw.net/jtv_user_pictures/xarth/404_user_300x300.png" alt="">
                                    <h5 class=" mt-2 ml-1">Ninja</h5>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between">
                                            <span>	<i class="icon-screen3"></i>
                                                <span class="badge badge-pill bg-teal-800 ml-1">128</span>
                                            </span>
                                            <span class="justify-content-center">
                                                <i class="icon-cube3"></i>
                                                <span class="badge badge-pill bg-teal-800 ml-1">300</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
<!-- /content area -->
</div>
@endsection
<script>
    const gameName = "{{ $gameName }}";
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/game.js')}}"></script>
@endsection
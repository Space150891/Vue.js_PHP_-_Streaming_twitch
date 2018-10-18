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
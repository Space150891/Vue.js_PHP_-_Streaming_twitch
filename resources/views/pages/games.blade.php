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
                        <div class="row" id="games-list">
                        </div>
                        <!-- /cards in grid columns -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('footer_scripts')
    <script src="js/pages/games.js"></script>
@endsection
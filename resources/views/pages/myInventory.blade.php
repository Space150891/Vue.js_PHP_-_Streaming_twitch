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
@endsection
<script>
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/myInventory.js')}}"></script>
@endsection
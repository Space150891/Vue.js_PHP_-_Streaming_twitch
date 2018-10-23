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
                            <li class="nav-item"><a href="#prices" class="nav-link rounded-top" data-toggle="tab">Prices</a></li>
                            <li class="nav-item"><a href="#frames" class="nav-link rounded-top" data-toggle="tab">Frames</a></li>
                            <li class="nav-item"><a href="#artworks" class="nav-link rounded-top" data-toggle="tab">Artworks</a></li>
                            <li class="nav-item"><a href="#achievements" class="nav-link rounded-top" data-toggle="tab">Achievements</a></li>

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
                                                            <div class="row">

                                                                <div class="col-xl-3 col-sm-6">

                                                                    <!-- Overlay buttons -->
                                                                    <div class="card">
                                                                        <div class="card-img-actions">
                                                                            <img class="card-img-top img-fluid" src="assets/images/Prices/price_0000000003.png" alt="">
                                                                            <div class="card-img-actions-overlay card-img-top">
                                                                                <a href="#" class="btn btn-outline bg-white text-white border-white border-2 ml-2" data-toggle="modal" data-target="#modal_price_0000000002">
                                                                                    Details
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="card-body  bg-dark">

                                                                            <h5 class="card-title font-weight-semibold">ROG Strix Fusion 500</h5>
                                                                            <p class="card-text">Type: <b>Hardware</b></p>
                                                                            <p class="card-text">Brand: <b>Asus</b></p>
                                                                        </div>

                                                                        <div class="card-footer d-flex justify-content-between bg-dark">
                                                                            <span><a href="https://streamcases.tv/profile/dlausch/redeem/1847782873" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left"><b><i class="icon-cart"></i></b>Redeem</a>
                                                                            </span>
                                                                            <span class="justify-content-center pt-2">
                                                                                <span class="badge badge-danger badge-pill">1.999$</span>

                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /overlay buttons -->

                                                                    <!-- modal_price_0000000001 -->
                                                                    <div id="modal_price_0000000002" class="modal fade" tabindex="-1">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">ROG Strix Fusion 500</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <p>
                                                                                        ROG GT51 is no ordinary gaming machine. It's engineered with ROG gaming DNA to give you mind-blowing gaming experiences you won't find elsewhere. Pump up the Intel® Core™ i7-6700K CPU to a full-core overclocked 4.6GHz —
                                                                                        without rebooting! — while you enjoy the eye-popping 8-million-color dynamic 4-zone LED lighting effects. ROG GT51: be prepared for awesome!
                                                                                    </p>

                                                                                    <hr>

                                                                                    <div class="embed-responsive embed-responsive-16by9">
                                                                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/78JrrFHHITw" frameborder="0" allowfullscreen></iframe>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <a href="https://www.asus.com/us/Tower-PCs/ROG-GT51CA" target="_blank" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-link"></i></b>Website</a>

                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <a href="https://streamcases.tv/profile/dlausch/redeem/1847782873" target="_self" class="btn bg-green-800 btn-labeled btn-labeled-left"><b><i class="icon-cart"></i></b>Redeem</a>

                                                                                    <button class="btn bg-danger-800 btn-labeled btn-labeled-left" data-dismiss="modal"><b><i class="icon-close2"></i></b>Close</button>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /modal_price_0000000001 -->

                                                                </div>

                                                            </div>

                                                            <!-- /grid -->

                                                            <!-- Pagination -->
                                                            <div class="d-flex justify-content-center pt-3 mb-3">
                                                                <ul class="pagination">
                                                                    <li class="page-item"><a href="#" class="page-link"><i class="icon-arrow-small-right"></i></a></li>
                                                                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                                                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                                                                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                                                                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                                                                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                                                                    <li class="page-item"><a href="#" class="page-link"><i class="icon-arrow-small-left"></i></a></li>
                                                                </ul>
                                                            </div>
                                                            <!-- /pagination -->

                                                        </div>
                                                        <!-- /left content -->

                                                    </div>

                                                    <div class="tab-pane fade" id="frames">

                                                        <!-- Left content -->
                                                        <div class="w-100 overflow-hidden">

                                                            <!-- Grid -->
                                                            <div class="row">

                                                                <div class="col-lg-3 col-sm-6">
                                                                    <!-- Middle placement -->
                                                                    <div class="card">
                                                                        <div class="card-body text-center">
                                                                            <h3 class="mb-0 font-weight-semibold ">StreamCases 8bit</h3>
                                                                            <div class="mb-0 font-weight-semibold">The Common</div>
                                                                            <hr>

                                                                        </div>

                                                                        <div class="text-center">
                                                                            <img class="img-fluid" src="assets/images/Frames/common_streamcases_8bit_common.png">

                                                </div>

                                                                            <div class="card-body bg-light text-center">
                                                                                <hr>
                                                                                <h6 class="font-weight-semibold mb-0">
                                                                                <h6 class="font-weight-bold">Common Frame</h6>
                                                                                </h6>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- /middle placement -->

                                                                </div>
                                                                <!-- /grid -->


                                                            </div>
                                                            <!-- /left content -->

                                                        </div>

                                                        <div class="tab-pane fade " id="artworks">
                                                            <!-- Left content -->
                                                            <div class="w-100 overflow-hidden">

                                                                <!-- Grid -->
                                                                <div class="row">

                                                                    <div class="col-lg-3 col-sm-6">
                                                                        <!-- Middle placement -->
                                                                        <div class="card">
                                                                            <div class="card-body text-center">
                                                                                <h3 class="mb-0 font-weight-semibold ">Dead Fish</h3>
                                                                                <div class="mb-0 font-weight-semibold">The Animals</div>
                                                                                <hr>

                                                                            </div>

                                                                            <div class="text-center">
                                                                                <img class="img-fluid" src="assets/images/Artworks/Animals/common_dead_fish.png">

                                                                                                            </div>

                                                                                <div class="card-body bg-light text-center">
                                                                                    <hr>
                                                                                    <h6 class="font-weight-semibold mb-0">
                                                                                    <h6 class="font-weight-bold">Common Artwork</h6>
                                                                                    </h6>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-6">
                                                                            <!-- Middle placement -->
                                                                            <div class="card">
                                                                                <div class="card-body text-center">
                                                                                    <h3 class="mb-0 font-weight-semibold ">Catelepath</h3>
                                                                                    <div class="mb-0 font-weight-semibold">The Animals</div>
                                                                                    <hr>

                                                                                </div>

                                                                                <div class="text-center">
                                                                                    <img class="img-fluid" src="assets/images/Artworks/Animals/uncommon_catelepath.png">

                                                                                                                </div>

                                                                                    <div class="card-body bg-light text-center">
                                                                                        <hr>
                                                                                        <h6 class="font-weight-semibold mb-0">
                                                                                        <h6 class="text-green-800 font-weight-bold">Uncommon Artwork</h6>
                                                                                        </h6>

                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-3 col-sm-6">
                                                                                <!-- Middle placement -->
                                                                                <div class="card">
                                                                                    <div class="card-body text-center">
                                                                                        <h3 class="mb-0 font-weight-semibold ">Spider King</h3>
                                                                                        <div class="mb-0 font-weight-semibold">The Animals</div>
                                                                                        <hr>

                                                                                    </div>

                                                                                    <div class="text-center">
                                                                                        <img class="img-fluid" src="assets/images/Artworks/Animals/legendary_spider_king.png">

                                                                                                                    </div>

                                                                                        <div class="card-body bg-light text-center">
                                                                                            <hr>
                                                                                            <h6 class="font-weight-semibold mb-0">
                                                                                            <h6 class="text-orange-800 font-weight-bold">Legendary Artwork</h6>
                                                                                            </h6>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <!-- Middle placement -->
                                                                                    <div class="card">
                                                                                        <div class="card-body text-center">
                                                                                            <h3 class="mb-0 font-weight-semibold ">Adventurer</h3>
                                                                                            <div class="mb-0 font-weight-semibold">The Animals</div>
                                                                                            <hr>

                                                                                        </div>

                                                                                        <div class="text-center">
                                                                                            <img class="img-fluid" src="assets/images/Artworks/Animals/rare_adventurer.png">

                                                                                                                        </div>

                                                                                            <div class="card-body bg-light text-center">
                                                                                                <hr>
                                                                                                <h6 class="font-weight-semibold mb-0">
                                                                                                <h6 class="text-blue-800 font-weight-bold">Rare Artwork</h6>
                                                                                                </h6>

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /middle placement -->

                                                                                </div>
                                                                                <!-- /grid -->

                                                                                <!-- Pagination -->
                                                                                <div class="d-flex justify-content-center pt-3 mb-3 ">
                                                                                    <ul class="pagination ">
                                                                                        <li class="page-item "><a href="# " class="page-link "><i class="icon-arrow-small-right "></i></a></li>
                                                                                        <li class="page-item active "><a href="# " class="page-link ">1</a></li>
                                                                                        <li class="page-item "><a href="# " class="page-link ">2</a></li>
                                                                                        <li class="page-item "><a href="# " class="page-link ">3</a></li>
                                                                                        <li class="page-item "><a href="# " class="page-link ">4</a></li>
                                                                                        <li class="page-item "><a href="# " class="page-link ">5</a></li>
                                                                                        <li class="page-item "><a href="# " class="page-link "><i class="icon-arrow-small-left "></i></a></li>
                                                                                    </ul>
                                                                                </div>
                                                                                <!-- /pagination -->

                                                                            </div>
                                                                            <!-- /left content -->
                                                                        </div>

                                                                        <div class="tab-pane fade " id="achievements">

                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div class="card">

                                                                                        <div class="card-body">

                                                                                            <li class="media">
                                                                                                <div class="mr-3 position-relative">
                                                                                                    <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                                    </div>
                                                                                                    <div class="media-body">
                                                                                                        <div class="media-title">

                                                                                                            <span class="font-weight-semibold">Welcome</span>

                                                                                                        </div>
                                                                                                        <span class="text-muted">Login the first time.</span>
                                                                                                    </div>
                                                                                            </li>

                                                                                        </div>

                                                                                        <div class="card-footer">

                                                                                            <div class="row">
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <span class="text-muted">Unlocked: April 12, 2018</span>
                                                                                                </div>
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <div class="list-icons float-right">
                                                                                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="card">

                                                                                        <div class="card-body">

                                                                                            <li class="media">
                                                                                                <div class="mr-3 position-relative">
                                                                                                    <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                                    </div>
                                                                                                    <div class="media-body">
                                                                                                        <div class="media-title">

                                                                                                            <span class="font-weight-semibold">Tier 1</span>

                                                                                                        </div>
                                                                                                        <span class="text-muted">Open a Tier 1 StreamCase for the first time.</span>
                                                                                                    </div>
                                                                                            </li>

                                                                                        </div>

                                                                                        <div class="card-footer">

                                                                                            <div class="row">
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <span class="text-muted">Unlocked: August 14, 2018</span>
                                                                                                </div>
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <div class="list-icons float-right">
                                                                                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div class="card">

                                                                                        <div class="card-body">

                                                                                            <li class="media">
                                                                                                <div class="mr-3 position-relative">
                                                                                                    <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                                    </div>
                                                                                                    <div class="media-body">
                                                                                                        <div class="media-title">

                                                                                                            <span class="font-weight-semibold">Faithful as a Penguine</span>

                                                                                                        </div>
                                                                                                        <span class="text-muted">Subscribe to 5 Channels</span>
                                                                                                    </div>
                                                                                            </li>

                                                                                        </div>

                                                                                        <div class="card-footer">

                                                                                            <div class="row">
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <div class="progress" id="h-fill-basic">
                                                                                                        <div class="progress-bar progress-bar-striped" data-transitiongoal-backup="75" data-transitiongoal="75" style="width: 75%">
                                                                                                            <span class="text-white font-weight-semibold">75%</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-xl-6 col-sm-12">

                                                                                                    <div class="list-icons float-right">
                                                                                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="card">

                                                                                        <div class="card-body">

                                                                                            <li class="media">
                                                                                                <div class="mr-3 position-relative">
                                                                                                    <img src="global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
                                                    </div>
                                                                                                    <div class="media-body">
                                                                                                        <div class="media-title">

                                                                                                            <span class="font-weight-semibold">Yet another generous moment</span>

                                                                                                        </div>
                                                                                                        <span class="text-muted">Your Total Donations (Globally) equals at least 20 USD</span>
                                                                                                    </div>
                                                                                            </li>

                                                                                        </div>

                                                                                        <div class="card-footer">

                                                                                            <div class="row">
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <div class="progress" id="h-fill-basic">
                                                                                                        <div class="progress-bar progress-bar-striped bg-danger" data-transitiongoal-backup="0" data-transitiongoal="0" style="width: 10%">
                                                                                                            <span class="text-white font-weight-semibold">0%</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-xl-6 col-sm-12">
                                                                                                    <div class="list-icons float-right">
                                                                                                        <i class="icon-cube3 ml-0"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-diamond ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack-empty ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>
                                                                                                        <i class="icon-stack4 ml-2"></i> <span class="badge badge-pill bg-teal-800 position-static">50</span>

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
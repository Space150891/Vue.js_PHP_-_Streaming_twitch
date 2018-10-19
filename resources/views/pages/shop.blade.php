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
                <h6 class="card-title">Store</h6>
                <div class="header-elements">

                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-solid border-0">
                    <li class="nav-item"><a href="#streamcases" class="nav-link rounded-top active" data-toggle="tab">StreamCases</a></li>
                    <li class="nav-item"><a href="#frames" class="nav-link rounded-top" data-toggle="tab">Frames (Comming Soon)</a></li>
                    <li class="nav-item"><a href="#artworks" class="nav-link rounded-top" data-toggle="tab">Artworks (Comming Soon)</a></li>


                </ul>

                <div class="tab-content">

                    <!-- DEV INFO - TBA - BUY MULTIPLE AT ONCE AND OPEN ONLY POSSIBLE LATER IN INVENTORY -->

                    <div class="tab-pane fade show active" id="streamcases">
                        
                    </div>

                    <div class="tab-pane fade" id="frames">
                        Comming Soon
                    </div>

                    <div class="tab-pane fade" id="artworks">
                        Comming Soon
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<!-- /rounded basic tabs -->

</div>
<!-- /content area -->
</div>

<div id="modal_buy_case" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#333333">
            <div class="modal-header">
                <h5 class="modal-title text-white">Buy <span id="buy-case-name"></span> StreamCase</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="buy-case-body">


            </div>

            <div class="modal-footer">

                <button class="btn bg-green-800 btn-labeled btn-labeled-left spin-button" onclick="buyCase()"><b><i class="icon-cart"></i></b>Buy</button>
                <button class="btn bg-danger-800 btn-labeled btn-labeled-left" data-dismiss="modal"><b><i class="icon-close2"></i></b>Close</button>

            </div>
        </div>
    </div>
</div>

@endsection
<script>
    let caseId = {{$caseId}};
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/shop.js')}}"></script>
@endsection
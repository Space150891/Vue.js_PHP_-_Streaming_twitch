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
                    <h6 class="card-title">Prices</h6>
                    <div class="header-elements">

                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-solid border-0">
                        <li class="nav-item"><a href="#prices-tier-1" class="nav-link rounded-top active" data-toggle="tab"  onclick="setRarity('common', 'prices-tier-1')">Tier 1</a></li>
                        <li class="nav-item"><a href="#prices-tier-2" class="nav-link rounded-top" data-toggle="tab"  onclick="setRarity('uncommon', 'prices-tier-2')">Tier 2</a></li>
                        <li class="nav-item"><a href="#prices-tier-3" class="nav-link rounded-top" data-toggle="tab" onclick="setRarity('rare', 'prices-tier-3')">Tier 3</a></li>
                        <li class="nav-item"><a href="#prices-tier-4" class="nav-link rounded-top" data-toggle="tab" onclick="setRarity('epic', 'prices-tier-4')">Tier 4</a></li>
                        <li class="nav-item"><a href="#prices-tier-5" class="nav-link rounded-top" data-toggle="tab" onclick="setRarity('legendary', 'prices-tier-5')">Tier 5</a></li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="prices-tier-1">

                        </div>

                        <div class="tab-pane fade" id="prices-tier-2">
                            Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
                        </div>

                        <div class="tab-pane fade" id="prices-tier-3" >
                            DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg whatever.
                        </div>

                        <div class="tab-pane fade" id="prices-tier-4" >
                            Aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthet.
                        </div>

                        <div class="tab-pane fade" id="prices-tier-5">
                            Aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthet.
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
@endsection

@section('footer_scripts')
    <script src="{{asset('js/pages/allPrizes.js')}}"></script>
@endsection
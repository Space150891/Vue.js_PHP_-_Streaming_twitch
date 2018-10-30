@extends('layouts.app')

@section('content')

<div class="content-wrapper">


<!-- Content area -->
<div class="content">

    <!-- Color variations -->
    <div class="mb-3 pt-2">
        <h6 class="mb-0 font-weight-semibold">
                         Upgrade
                         </h6>
        <span class="text-muted d-block">Pricing</span>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-6 col-lg-2">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mt-2 mb-3">Basic</h4>
                    <h1 class="pricing-table-price"><span class="mr-1">$</span>9.99</h1>
                    <ul class="pricing-table-list list-unstyled mb-3">
                        <li><strong>5 Credits</strong> per Minute</li>

                    </ul>
                    <a href="#" class="btn bg-danger-800 btn-lg text-uppercase font-size-sm font-weight-semibold">Upgrade</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-2">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mt-2 mb-3">Advanced</h4>
                    <h1 class="pricing-table-price"><span class="mr-1">$</span>19.99</h1>
                    <ul class="pricing-table-list list-unstyled mb-3">
                        <li><strong>10 Credits</strong> per Minute</li>

                        <li><strong>Custom</strong> Donation Page</li>
                    </ul>
                    <a href="#" class="btn bg-danger-800 btn-lg text-uppercase font-size-sm font-weight-semibold">Upgrade</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-2">
            <div class="card bg-success-800">
                <div class="card-body text-center">
                    <h4 class="mt-2 mb-3">Golden</h4>
                    <h1 class="pricing-table-price"><span class="mr-1">$</span>49.99</h1>
                    <ul class="pricing-table-list list-unstyled mb-3">
                        <li><strong>55 Credits</strong> per Minute</li>
                        <li><strong>Custom</strong> Donation Page</li>
                        <li><strong>Own</strong> Achievement</li>
                        <li>Own<strong> Rare</strong> Artwork *</li>

                    </ul>
                    <a href="#" class="btn bg-danger-800 btn-lg text-uppercase font-size-sm font-weight-semibold">Upgrade</a>
                </div>

                <div class="ribbon-container">
                    <div class="ribbon bg-danger-400">Popular</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /color variations -->


    <!-- Questions list -->
    <div class="card-group-control card-group-control-right">
        <div class="card mb-2">
            <div class="card-header">
                <h6 class="card-title">
                                            <a class="text-default collapsed" data-toggle="collapse" href="#question1">
                                                <i class="icon-help mr-2 text-slate"></i> Credits per Minute?
                                            </a>
                                        </h6>
            </div>

            <div id="question1" class="collapse">
                <div class="card-body">
                    Credits per Minute define the minimum amount of Credits, your viewers earn for watching your Stream.
                    As more Credits your Channel reward, as more Traffic you can expect. Viewers will usually try to catch the Channels, that reward higher then
                    others.
                </div>


            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h6 class="card-title">
                                            <a class="text-default collapsed" data-toggle="collapse" href="#question2">
                                                <i class="icon-help mr-2 text-slate"></i> Custom Donation Page?
                                            </a>
                                        </h6>
            </div>

            <div id="question2" class="collapse">
                <div class="card-body">
                    Viewers can Donate to your Channel to get extra / higher rewards for watching you. You can customize your Donation Page using you own Graphics.
                </div>


            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h6 class="card-title">
                                            <a class="text-default collapsed" data-toggle="collapse" href="#question3">
                                                <i class="icon-help mr-2 text-slate"></i> Own Achivement?
                                            </a>
                                        </h6>
            </div>

            <div id="question3" class="collapse">
                <div class="card-body">
                    Viewers can use their Achivements to design their Game Cards. Having your own Achivement may motivate Viewers to watch your Channel at least for a certrain time even if others may more profitable. Each Viewer that want to unluck your special
                    Achivement have to watch your Channel for at least 6 hours.


                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h6 class="card-title">
                                            <a class="text-default collapsed" data-toggle="collapse" href="#question4">
                                                <i class="icon-help mr-2 text-slate"></i> Own Artwork?
                                            </a>
                                        </h6>
            </div>

            <div id="question4" class="collapse">
                <div class="card-body">
                    Viewers can use their Artworks to design their Game Cards. Having your own Artwork may motivate Viewers to watch your Channel at least for a certrain time even if others may more profitable. Each Viewer that want to unluck your special
                    Artwork have to watch your Channel for at least 24. You may have to upload your Artwork to use this feature. We have to manually review your Artwork before publishing it. It is also possible that we create a custom Artwork for you.
                    That circumstance have be to bespoken between us. Depending on the Plan you choose, you may get your Artwork promoted to Rare, Epic or Legendary. The unlock requirements for Rare are 24 Hours, Epic 48 Hours and Legendary 96 Hours.


                </div>
            </div>
        </div>
    </div>

    <!-- /questions list -->


    <!-- Title with left icon -->
    <div class="card">
        <div class="card-header bg-white">
            <h6 class="card-title">
                                        * If you subscribe for at least 3 Month, then, if you want, we will create a custom Artwork especially for you and for free.
                                    </h6>
        </div>


    </div>
    <!-- /title with left icon -->
</div>

<!-- /content area -->
</div>

@endsection
<script>
</script>
@section('footer_scripts')
    
@endsection
@extends('layouts.app')

@section('content')

<!-- Main content -->
<div class="content-wrapper">


<!-- Content area -->
<div class="content">


    <div class="card">


        <div class="card-body">
            <h5 class="card-title" id="prize-name"></h5>
            <p id="prize-class"></p>
            <p id="prize-description"></p>
            <p>Type: <b>Hardware</b></p>
            <p>Brand: <b>Asus</b></p>
            <p class="mb-3">Worth: <b>$<span id="prize-cost"></span></b></p>
            <p>This Price have to be shipped and is located in our <b>Warehouse in EU/Romania</b> </p>
            <p><b>The Price is free of charge but you have to pay the shipment costs for this Price!</b></p>
            <p class="mb-3">Click on the Button <b>"Ship My Price Now!"</b> to start the initiation of the shipping progress.</p>

            <!-- DEV INFO: IN THIS CASE SHOW THE USER A LIST OF AVAILABL PAYMENT PROCESSORS AND LET THEM PAY THE SHIPMENT PRICE. WE MAY NEED TO CALC THIS. SO FOR
            EXAMPLE IF THE PRICE IS IN EU (AS IT WILL BE FOR A LOT OF TIME JUST IN EU / IN MY OFFICE - AND THE RECEIVER IS IN US "WE" HAVE TO CALC THE SHIPMENT PRICE. I WILL CHOOSE THE LOGISTIC PROVIDERS ASAP AND TELL YOU. THEN YOU MAY IMPLEMENT A CALC FOR A PRICE TABLE I WILL SUPPLY YOU. WE WILL PROBABLY GO FOR DHL AND UPS
        AND BTW always keep in mind. if somebody win a price that worth $$$ if redeemed or not already it counts as OUTCOME -> this is important for the algo to dont pay out too much! -->

            <p class="mb-3"><b>Information:</b></p>
            <p>If we do not have the Price on Stock, then we´ll order the Price directly from online Stores like <b>Amazon</b> or <b>Newegg</b> and we´ll provide directly your Address as receiver. There will be no shipment costs for you in this Case!</p>
            <p>If the Price is not available anymore, we´ll contact you to discuss about an alternative that worth about the same as the Price you won. </p>
            <p class="mb-3">Depending on the Price´s and your location, the <b>shipment may take between 2 and 14 business days.</b></p>

            <button type="submit" class="btn bg-success-800">Ship My Price Now!</button>

        </div>
    </div>

</div>
<!-- /content area -->
</div>
<!-- /main content -->

@endsection
<script>
    const prizeId = "{{ $prizeId }}";
</script>
@section('footer_scripts')
    <script src="{{asset('js/pages/redeem.js')}}"></script>
@endsection
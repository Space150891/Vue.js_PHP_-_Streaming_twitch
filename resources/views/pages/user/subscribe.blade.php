@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <h1>{{ trans('subscribe.titleForm') }}</h1>
        <form action={{ url('subscribe') }} method="POST" id="payment-form">
            @csrf
            <span class="payment-errors"></span>
            <label>{{ trans('subscribe.cardNumber') }}</label>
            <input type="text" size="20" data-stripe="number" name="number">
            <label>{{ trans('subscribe.expiration') }} (MM/YY)</label>     
            <input type="text" size="2" data-stripe="exp_month"  name="exp_month">
            <input type="text" size="2" data-stripe="exp_year" name="exp_year">
            <label>CVC</label>
            <input type="text" size="4" data-stripe="cvc" name="cvc">
            <input type="submit" class="submit" value="{{ trans('subscribe.pay') }}">
        </form>
    </div>

@endsection

@section('footer_scripts')
@endsection
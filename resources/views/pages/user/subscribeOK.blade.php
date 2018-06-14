@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <h1>{{ trans('subscribe.titleResult') }}</h1>
        <p>{{ $message }}</p>
    </div>

@endsection

@section('footer_scripts')
@endsection
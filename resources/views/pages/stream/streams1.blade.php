@extends('layouts.stream')

@section('template_title')
    Stream dashboard
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <h3>Video</h3>
        <iframe
            src={{ twitchVideoUrl($channel) }}
            height="500px"
            width=100%
            frameborder="0"
            scrolling="no"
            allowfullscreen="false">
        </iframe>
    </div>
    <div class="col-md-4">
        <h3>Chat</h3>
        <iframe frameborder="1"
            scrolling="true"
            src={{ twitchChatUrl($channel) }}
            height="100%"
            width="100%">
        </iframe>
    </div>
</div>

@endsection

@section('footer_scripts')
@endsection
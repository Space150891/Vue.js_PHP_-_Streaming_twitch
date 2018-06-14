@extends('layouts.stream')

@section('template_title')
    Stream dashboard
@endsection

@section('template_fastload_css')
@endsection

@section('header_scripts')
<script>
    var channelsUrl = [];
    channelsUrl.push('<?= twitchChatUrl($channels[0])?>');
    channelsUrl.push('<?= twitchChatUrl($channels[1])?>');
    channelsUrl.push('<?= twitchChatUrl($channels[2])?>');
    channelsUrl.push('<?= twitchChatUrl($channels[3])?>');
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <h3>Video</h3>
        <div class="row">
            <div class="col-md-6">
                <iframe
                    src={{ twitchVideoUrl($channels[0]) }}
                    height="200px"
                    width=100%
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="false">
                </iframe>
            </div>
            <div class="col-md-6">
                <iframe
                    src={{ twitchVideoUrl($channels[1]) }}
                    height="200px"
                    width=100%
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="false">
                </iframe>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <iframe
                    src={{ twitchVideoUrl($channels[2]) }}
                    height="200px"
                    width=100%
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="false">
                </iframe>
            </div>
            <div class="col-md-6">
                <iframe
                    src={{ twitchVideoUrl($channels[3]) }}
                    height="200px"
                    width=100%
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="false">
                </iframe>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h3>Chat</h3>
        <chat-tabs><chat-tabs />
    </div>
</div>
@endsection

@section('footer_scripts')

@endsection
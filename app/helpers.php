<?php

function twitchVideoUrl($channelName) {
    return "https://player.twitch.tv/?channel={$channelName}";
}

function twitchChatUrl($channelName) {
    return "https://www.twitch.tv/embed/{$channelName}/chat";
}

function getOrigin(Array $server) :string{
    if (array_key_exists('HTTP_ORIGIN', $server)) {
        return $server['HTTP_ORIGIN'];
    }
    else if (array_key_exists('HTTP_REFERER', $server)) {
        return $server['HTTP_REFERER'];
    } else {
        return $server['REMOTE_ADDR'];
    }
}
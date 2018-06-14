<?php

function twitchVideoUrl($channelName) {
    return "https://player.twitch.tv/?channel={$channelName}";
}

function twitchChatUrl($channelName) {
    return "https://www.twitch.tv/embed/{$channelName}/chat";
}
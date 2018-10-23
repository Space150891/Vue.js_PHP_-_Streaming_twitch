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
    } elseif (array_key_exists('REMOTE_ADDR', $server)) {
        return $server['REMOTE_ADDR'];
    } else {
        return '';
    }
}

function multiMerge($array1, $array2)
{
    $data = [];
    foreach ($array1 as $ar1) {
        $data[] = $ar1;
    }
    foreach ($array2 as $ar2) {
        $data[] = $ar2;
    }
    return $data;
}

function convertDate($stringDate) {
    return date("F j, Y", strtotime($stringDate));
}
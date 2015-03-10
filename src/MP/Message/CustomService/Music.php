<?php
namespace Xueba\WxApi\MP\Message\CustomService;

class Music
{
    const JSON_TEMPLATE = <<<JSON
{
    "touser":"%s",
    "msgtype":"music",
    "music":
    {
        "title":"%s",
        "description":"%s",
        "musicurl":"%s",
        "hqmusicurl":"%s",
        "thumb_media_id":"%s"
    },
    "customservice":
    {
        "kf_account": "%s"
    }
}
JSON;

    public static function getJson($toUser, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId, $kfAccount = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId, $kfAccount);
    }
}

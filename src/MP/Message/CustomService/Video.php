<?php
namespace Xueba\WxApi\MP\Message\CustomService;

class Video
{
    const JSON_TEMPLATE = <<<JSON
{
    "touser":"%s",
    "msgtype":"video",
    "video":
    {
        "media_id":"%s",
        "thumb_media_id":"%s",
        "title":"%s",
        "description":"%s"
    },
    "customservice":
    {
        "kf_account": "%s"
    }
}
JSON;

    public static function getJson($toUser, $mediaId, $thumbMediaId, $title, $description, $kfAccount = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $mediaId, $thumbMediaId, $title, $description, $kfAccount);
    }
}

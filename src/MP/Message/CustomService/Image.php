<?php
namespace Xueba\WxApi\MP\Message\CustomService;

class Image
{
    const JSON_TEMPLATE = <<<JSON
{
    "touser":"%s",
    "msgtype":"image",
    "image":
    {
        "media_id":"%s"
    },
    "customservice":
    {
        "kf_account": "%s"
    }
}
JSON;

    public static function getJson($toUser, $mediaId, $kfAccount = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $mediaId, $kfAccount);
    }
}

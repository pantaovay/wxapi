<?php
namespace Xueba\WxApi\MP\Message\CustomService;

class Text
{
    const JSON_TEMPLATE = <<<JSON
{
    "touser":"%s",
    "msgtype":"text",
    "text":
    {
        "content":"%s"
    },
    "customservice":
    {
        "kf_account": "%s"
    }
}
JSON;

    public static function getJson($toUser, $content, $kfAccount = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $content, $kfAccount);
    }
}

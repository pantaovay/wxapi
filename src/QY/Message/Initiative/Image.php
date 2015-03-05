<?php
namespace Xueba\WxApi\QY\Message\Initiative;

class Image
{
    const JSON_TEMPLATE = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "image",
   "agentid": "%s",
   "image": {
       "media_id": "%s"
   },
   "safe":"0"
}
JSON;

    public static function getJson($agentId, $mediaId, $toUser = '@all', $toParty = '', $toTag = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $toParty, $toTag, $agentId, $mediaId);
    }
}

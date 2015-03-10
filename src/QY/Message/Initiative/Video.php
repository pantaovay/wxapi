<?php
namespace Xueba\WxApi\QY\Message\Initiative;

class Video
{
    const JSON_TEMPLATE = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "video",
   "agentid": "%s",
   "video": {
       "media_id": "%s",
       "title": "%s",
       "description": "%s"
   },
   "safe":"%s"
}
JSON;

    public static function getJson($agentId, $mediaId, $title, $description, $toUser = '@all', $toParty = '', $toTag = '', $safe = 0)
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $toParty, $toTag, $agentId, $mediaId, $title, $description, $safe);
    }
}

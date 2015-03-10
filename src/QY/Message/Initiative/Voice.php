<?php
namespace Xueba\WxApi\QY\Message\Initiative;

class Voice
{
    const JSON_TEMPLATE = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "voice",
   "agentid": "%s",
   "voice": {
       "media_id": "%s"
   },
   "safe":"%s"
}
JSON;

    public static function getJson($agentId, $mediaId, $toUser = '@all', $toParty = '', $toTag = '', $safe = 0)
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $toParty, $toTag, $agentId, $mediaId, $safe);
    }
}

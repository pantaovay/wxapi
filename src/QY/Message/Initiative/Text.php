<?php
namespace Xueba\WxApi\QY\Message\Initiative;

class Text
{
    const JSON_TEMPLATE = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "text",
   "agentid": "%s",
   "text": {
       "content": "%s"
   },
   "safe":"0"
}
JSON;

    public static function getJson($agentId, $content, $toUser = '@all', $toParty = '', $toTag = '')
    {
        return sprintf(self::JSON_TEMPLATE, $toUser, $toParty, $toTag, $agentId, $content);
    }
}
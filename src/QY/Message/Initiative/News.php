<?php
namespace Xueba\WxApi\QY\Message\Initiative;

class News
{
    const JSON_TEMPLATE_HEADER = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "news",
   "agentid": "%s",
   "news": {
       "articles":[
JSON;
    const JSON_TEMPLATE_ARTICLE = <<<JSON
           {
               "title": "%s",
               "description": "%s",
               "url": "%s",
               "picurl": "%s"
           }
JSON;
    const JSON_TEMPLATE_FOOTER = <<<JSON
        ]
   }
}
JSON;

    public static function getJson($agentId, array $articles = [], $toUser = '@all', $toParty = '', $toTag = '')
    {
        $articleJsonStrings = array();
        foreach ($articles as $article)
        {
            $articleJsonStrings[] = sprintf(self::JSON_TEMPLATE_ARTICLE, $article['title'], $article['description'], $article['url'], $article['picurl']);
        }
        return sprintf(self::JSON_TEMPLATE_HEADER, $toUser, $toParty, $toTag, $agentId) . implode(',', $articleJsonStrings) . self::JSON_TEMPLATE_FOOTER;
    }
}

<?php
namespace Xueba\WxApi\QY\Message\Initiative;

use Xueba\WxApi\Exception;

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

    const MAX_ARTICLES = 10;

    public static function getJson($agentId, array $articles = [], $toUser = '@all', $toParty = '', $toTag = '')
    {
        if (count($articles) > self::MAX_ARTICLES)
        {
            throw new Exception('Articles cannot exclude ' . self::MAX_ARTICLES);
        }
        $articleJsonStrings = array();
        foreach ($articles as $article)
        {
            $articleJsonStrings[] = sprintf(self::JSON_TEMPLATE_ARTICLE, $article['title'], $article['description'], $article['url'], $article['picurl']);
        }
        return sprintf(self::JSON_TEMPLATE_HEADER, $toUser, $toParty, $toTag, $agentId) . implode(',', $articleJsonStrings) . self::JSON_TEMPLATE_FOOTER;
    }
}

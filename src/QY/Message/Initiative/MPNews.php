<?php
namespace Xueba\WxApi\QY\Message\Initiative;

use Xueba\WxApi\Exception;

class MPNews
{
    const JSON_TEMPLATE_HEADER = <<<JSON
{
   "touser": "%s",
   "toparty": "%s",
   "totag": "%s",
   "msgtype": "mpnews",
   "agentid": "%s",
   "mpnews": {
       "articles":[
JSON;
    const JSON_TEMPLATE_ARTICLE = <<<JSON
           {
               "title": "%s",
               "thumb_media_id": "%s",
               "author": "%s",
               "content_source_url": "%s",
               "content": "%s",
               "digest": "%s",
               "show_cover_pic": "%s"
           }
JSON;
    const JSON_TEMPLATE_FOOTER = <<<JSON
        ]
   },
   "safe":"%s"
}
JSON;

    const MAX_ARTICLES = 10;

    public static function getJson($agentId, array $articles = [], $toUser = '@all', $toParty = '', $toTag = '', $safe = 0)
    {
        if (count($articles) > self::MAX_ARTICLES)
        {
            throw new Exception('Articles cannot exclude ' . self::MAX_ARTICLES);
        }
        $articleJsonStrings = array();
        foreach ($articles as $article)
        {
            $articleJsonStrings[] = sprintf(
                self::JSON_TEMPLATE_ARTICLE,
                $article['title'], $article['thumb_media_id'], $article['author'], $article['content_source_url'], $article['content'], $article['digest'], $article['show_cover_pic']
            );
        }
        return sprintf(self::JSON_TEMPLATE_HEADER, $toUser, $toParty, $toTag, $agentId) . implode(',', $articleJsonStrings) . sprintf(self::JSON_TEMPLATE_FOOTER, $safe);
    }
}

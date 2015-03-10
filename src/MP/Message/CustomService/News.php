<?php
namespace Xueba\WxApi\MP\Message\CustomService;

use Xueba\WxApi\Exception;

class News
{
    const JSON_TEMPLATE_HEADER = <<<JSON
{
   "touser": "%s",
   "msgtype": "news",
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
   },
    "customservice":
    {
        "kf_account": "%s"
    }
}
JSON;

    const MAX_ARTICLES = 10;

    public static function getJson($toUser, array $articles = [], $kfAccount = '')
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
        return sprintf(self::JSON_TEMPLATE_HEADER, $toUser) . implode(',', $articleJsonStrings) . sprintf(self::JSON_TEMPLATE_FOOTER, $kfAccount);
    }
}

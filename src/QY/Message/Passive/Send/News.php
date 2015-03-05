<?php
namespace Xueba\WxApi\QY\Message\Passive\Send;

class News
{
    const XML_TEMPLATE_HEADER = <<<HEADER
<xml>
   <ToUserName><![CDATA[%s]]></ToUserName>
   <FromUserName><![CDATA[%s]]></FromUserName>
   <CreateTime>%s</CreateTime>
   <MsgType><![CDATA[news]]></MsgType>
   <ArticleCount>%s</ArticleCount>
   <Articles>
HEADER;

    const XML_TEMPLATE_ITEM = <<<ITEM
        <item>
           <Title><![CDATA[%s]]></Title>
           <Description><![CDATA[%s]]></Description>
           <PicUrl><![CDATA[%s]]></PicUrl>
           <Url><![CDATA[%s]]></Url>
       </item>
ITEM;
    const XML_TEMPLATE_FOOTER = <<<FOOTER
    </Articles>
</xml>
FOOTER;

    public static function getXml($toUserName, $fromUserName, $createTime, array $news)
    {
        $xml = sprintf(self::XML_TEMPLATE_HEADER, $toUserName, $fromUserName, $createTime, count($news));
        foreach ($news as $article)
        {
            $xml .= sprintf(self::XML_TEMPLATE_ITEM, $article['title'], $article['description'], $article['picurl'], $article['url']);
        }
        $xml .= self::XML_TEMPLATE_FOOTER;

        return $xml;
    }
}

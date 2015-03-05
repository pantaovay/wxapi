<?php
namespace Xueba\WxApi\QY\Message\Passive\Send;

class Text
{
    const XML_TEMPLATE = <<<XML
<xml>
   <ToUserName><![CDATA[%s]]></ToUserName>
   <FromUserName><![CDATA[%s]]></FromUserName>
   <CreateTime>%s</CreateTime>
   <MsgType><![CDATA[text]]></MsgType>
   <Content><![CDATA[%s]]></Content>
</xml>
XML;

    public static function getXml($toUserName, $fromUserName, $createTime, $content)
    {
        return sprintf(self::XML_TEMPLATE, $toUserName, $fromUserName, $createTime, $content);
    }
}
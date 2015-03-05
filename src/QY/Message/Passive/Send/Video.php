<?php
namespace Xueba\WxApi\QY\Message\Passive\Send;

class Video
{
    const XML_TEMPLATE = <<<XML
<xml>
   <ToUserName><![CDATA[%s]]></ToUserName>
   <FromUserName><![CDATA[%s]]></FromUserName>
   <CreateTime>%s</CreateTime>
   <MsgType><![CDATA[video]]></MsgType>
   <Video>
       <MediaId><![CDATA[%s]]></MediaId>
       <Title><![CDATA[%s]]></Title>
       <Description><![CDATA[%s]]></Description>
   </Video>
</xml>
XML;


    public static function getXml($toUserName, $fromUserName, $createTime, $mediaId, $title, $description)
    {
        return sprintf(self::XML_TEMPLATE, $toUserName, $fromUserName, $createTime, $mediaId, $title, $description);
    }
}

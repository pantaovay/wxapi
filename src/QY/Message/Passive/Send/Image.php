<?php
namespace Xueba\WxApi\QY\Message\Passive\Send;

class Image
{
    const XML_TEMPLATE = <<<XML
<xml>
   <ToUserName><![CDATA[%s]]></ToUserName>
   <FromUserName><![CDATA[%s]]></FromUserName>
   <CreateTime>%s</CreateTime>
   <MsgType><![CDATA[image]]></MsgType>
   <Image>
       <MediaId><![CDATA[%s]]></MediaId>
   </Image>
</xml>
XML;

    public static function getXml($toUserName, $fromUserName, $createTime, $mediaId)
    {
        return sprintf(self::XML_TEMPLATE, $toUserName, $fromUserName, $createTime, $mediaId);
    }
}

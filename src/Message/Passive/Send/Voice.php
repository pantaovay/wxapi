<?php
namespace Xueba\WxApi\Message\Passive\Send;

class Voice
{
    const XML_TEMPLATE = <<<XML
<xml>
   <ToUserName><![CDATA[%s]]></ToUserName>
   <FromUserName><![CDATA[%s]]></FromUserName>
   <CreateTime>%s</CreateTime>
   <MsgType><![CDATA[voice]]></MsgType>
   <Voice>
       <MediaId><![CDATA[%s]]></MediaId>
   </Voice>
</xml>
XML;

    public static function getXml($toUserName, $fromUserName, $createTime, $mediaId)
    {
        return sprintf(self::XML_TEMPLATE, $toUserName, $fromUserName, $createTime, $mediaId);
    }
}

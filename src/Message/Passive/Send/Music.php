<?php
namespace Xueba\WxApi\Message\Passive\Send;

class Music
{
    const XML_TEMPLATE = <<<XML
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    <Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    </Music>
</xml>
XML;

    public static function getXml($toUserName, $fromUserName, $createTime, $thumbMediaId, $title = '', $description = '', $musicUrl = '', $hqMusicUrl = '')
    {
        return sprintf(self::XML_TEMPLATE, $toUserName, $fromUserName, $createTime, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId);
    }
}

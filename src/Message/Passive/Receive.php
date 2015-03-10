<?php
namespace Xueba\WxApi\Message\Passive;

/**
 * Class Receive 解析接收消息与事件
 */
class Receive
{
    private $_xmlStr;
    private $_xml;
    private $_xmlJson;

    public function __construct($xmlStr)
    {
        $this->_xmlStr = $xmlStr;
        $this->_xml = simplexml_load_string($xmlStr, "SimpleXMLElement", LIBXML_NOCDATA);
    }

    public function toArray($key = null)
    {
        if (is_null($this->_xmlJson))
        {
            $this->_xmlJson = json_decode(json_encode($this->_xml), true);
        }
        if (is_null($key))
        {
            return $this->_xmlJson;
        }
        else
        {
            return $this->_xmlJson[$key];
        }
    }
}

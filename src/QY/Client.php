<?php
namespace Xueba\WxApi\QY;
use GuzzleHttp\Event\CompleteEvent;

class Client extends \GuzzleHttp\Client
{
    const BASE_URL = 'https://qyapi.weixin.qq.com';
    const GET_ACCESS_TOKEN_URI = 'cgi-bin/gettoken';
    const SEND_MESSAGE_URI = 'cgi-bin/message/send';

    private $_corpId;
    private $_corpSecret;
    private $_token;
    private $_encodingAesKey;

    private static $_wxcpt;

    public function __construct($corpId, $corpSecret, $token = null, $encodingAesKey = null, array $config = [])
    {
        parent::__construct(array_merge($config, ['base_url' => self::BASE_URL]));
        $this->_corpId = $corpId;
        $this->_corpSecret = $corpSecret;
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;

        if (!is_null($token) && !is_null($encodingAesKey))
        {
            self::$_wxcpt = new \WXBizMsgCrypt($this->_token, $this->_encodingAesKey, $this->_corpId);
        }
        $this->getEmitter()->on('complete', function (CompleteEvent $e) {
            $result = $e->getResponse()->json();
            if (isset($result['errcode']) && $result['errcode'] != 0)
            {
                throw new Exception($result['errmsg'], $result['errcode']);
            }
        });
    }

    public function getAccessToken()
    {
        $response = $this->get(self::GET_ACCESS_TOKEN_URI, [
            'query' => ['corpid' => $this->_corpId, 'corpsecret' => $this->_corpSecret]
        ]);
        return $response->json()['access_token'];
    }

    public function sendMessage($jsonMessage)
    {
        $response = $this->post(self::SEND_MESSAGE_URI, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body'  => $jsonMessage,
        ]);

        return $response->json();
    }

    public function getReplyEchoStr($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr)
    {
        $sReplyEchoStr = '';
        self::_getWxcpt()->VerifyURL($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr, $sReplyEchoStr);
        return $sReplyEchoStr;
    }

    public function encryptMsg($sReplyMsg, $sTimeStamp, $sNonce)
    {
        $sEncryptMsg = '';
        $errCode = self::_getWxcpt()->EncryptMsg($sReplyMsg, $sTimeStamp, $sNonce, $sEncryptMsg);
        if ($errCode != 0)
        {
            throw new Exception('', $errCode);
        }
        return $sEncryptMsg;
    }

    public function decryptMsg($sMsgSignature, $sTimeStamp = null, $sNonce, $sPostData)
    {
        $sMsg = '';
        $errCode = self::_getWxcpt()->DecryptMsg($sMsgSignature, $sTimeStamp, $sNonce, $sPostData, $sMsg);
        if ($errCode != 0)
        {
            throw new Exception('', $errCode);
        }
        return $sMsg;
    }

    private static function _getWxcpt()
    {
        if (is_null(self::$_wxcpt))
        {
            throw new \Exception('Token and encodingAesKey needed!');
        }
        return self::$_wxcpt;
    }
}

<?php
namespace Xueba\WxApi;

trait Crypt
{
    private $_token;
    private $_encodingAesKey;

    private static $_wxcpt;

    public function verifyUrl($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr)
    {
        $sReplyEchoStr = '';
        $errCode = self::_getWxcpt()->VerifyURL($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr, $sReplyEchoStr);
        if ($errCode != 0)
        {
            throw new Exception('', $errCode);
        }
    }

    public function getReplyEchoStr($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr)
    {
        $sReplyEchoStr = '';
        $errCode = self::_getWxcpt()->VerifyURL($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr, $sReplyEchoStr);
        if ($errCode != 0)
        {
            throw new Exception('', $errCode);
        }
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

    /**
     * @return \WXBizMsgCrypt
     * @throws Exception
     */
    private static function _getWxcpt()
    {
        if (is_null(self::$_wxcpt))
        {
            throw new Exception('Token and encodingAesKey needed!');
        }
        return self::$_wxcpt;
    }

    /**
     * 公众平台的验证逻辑不一样
     *
     * @return bool
     */
    public function checkSignature($signature, $timestamp, $nonce)
    {
        $tmpArr = array($this->_token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = sha1(implode($tmpArr));

        return ($tmpStr == $signature);
    }
}
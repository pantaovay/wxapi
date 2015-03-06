<?php
namespace Xueba\WxApi\QY;

class Exception extends \Exception
{
    private static $_cryptErrcodeAndErrmsg = array(
        '-40001' =>	'签名验证错误',
        '-40002' =>	'xml解析失败',
        '-40003' =>	'sha加密生成签名失败',
        '-40004' =>	'AESKey 非法',
        '-40005' =>	'corpid 校验错误',
        '-40006' =>	'AES 加密失败',
        '-40007' =>	'AES 解密失败',
        '-40008' =>	'解密后得到的buffer非法',
        '-40009' =>	'base64加密失败',
        '-40010' =>	'base64解密失败',
        '-40011' =>	'生成xml失败',
    );

    public function __construct($message = '', $code)
    {
        if (in_array($code, array_keys(self::$_cryptErrcodeAndErrmsg)))
        {
            parent::__construct(self::$_cryptErrcodeAndErrmsg[$code], $code);
        }
        else
        {
            parent::__construct($message, $code);
        }
    }
}
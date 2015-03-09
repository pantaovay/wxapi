<?php
namespace Xueba\WxApi\QY;
use GuzzleHttp\Event\CompleteEvent;
use Xueba\WxApi\Crypt;
use Xueba\WxApi\Exception;

class Client extends \GuzzleHttp\Client
{
    use Crypt;
    use AccessToken, AddressBook, Message, Menu, Media, OAuth2;

    const BASE_URL = 'https://qyapi.weixin.qq.com';

    private $_corpId;
    private $_corpSecret;

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
            $response = $e->getResponse();
            if ($response->getHeader('Content-Type') == 'application/json; charset=utf-8')
            {
                $result = $response->json();
                if (isset($result['errcode']) && $result['errcode'] != 0)
                {
                    throw new Exception($result['errmsg'], $result['errcode']);
                }
            }
        });
    }
}

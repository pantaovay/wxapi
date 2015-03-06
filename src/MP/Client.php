<?php
namespace Xueba\WxApi\MP;
use GuzzleHttp\Event\CompleteEvent;
use Xueba\WxApi\Crypt;
use Xueba\WxApi\Exception;

class Client extends \GuzzleHttp\Client
{
    use Crypt;

    const BASE_URL = 'https://api.weixin.qq.com';
    const GET_ACCESS_TOKEN_URI = 'cgi-bin/token';

    private $_appid;
    private $_secret;

    public function __construct($appId, $secret, $token = null, $encodingAesKey = null, array $config = [])
    {
        parent::__construct(array_merge($config, ['base_url' => self::BASE_URL]));
        $this->_appid = $appId;
        $this->_secret = $secret;
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;

        if (!is_null($token) && !is_null($encodingAesKey))
        {
            self::$_wxcpt = new \WXBizMsgCrypt($this->_token, $this->_encodingAesKey, $this->_appid);
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
            'query' => ['grant_type' => 'client_credential', 'appid' => $this->_appid, 'secret' => $this->_secret]
        ]);
        return $response->json()['access_token'];
    }
}

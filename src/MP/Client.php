<?php
namespace Xueba\WxApi\MP;
use GuzzleHttp\Event\CompleteEvent;
use Xueba\WxApi\Client as CommClient;
use Xueba\WxApi\Basic;
use Xueba\WxApi\Crypt;
use Xueba\WxApi\Media;
use Xueba\WxApi\Menu;

class Client extends \GuzzleHttp\Client
{
    use Basic, CommClient, Crypt, Media, Menu;
    use AccessToken, CustomService;

    const BASE_URL = 'https://api.weixin.qq.com';
    const MEDIA_BASE_URL = 'http://file.api.weixin.qq.com';

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

        $this->setCompleteEvent();
    }
}

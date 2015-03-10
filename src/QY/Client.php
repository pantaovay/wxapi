<?php
namespace Xueba\WxApi\QY;
use Xueba\WxApi\Basic;
use Xueba\WxApi\Client as CommClient;
use Xueba\WxApi\Crypt;
use Xueba\WxApi\Media;
use Xueba\WxApi\Menu;

class Client extends \GuzzleHttp\Client
{
    use Basic, CommClient, Crypt, Media, Menu;
    use AccessToken, AddressBook, Message, OAuth2;

    const BASE_URL = 'https://qyapi.weixin.qq.com';
    const MEDIA_BASE_URL = 'https://qyapi.weixin.qq.com';

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

        $this->setCompleteEvent();
    }
}

<?php
namespace Xueba\WxApi\QY;

trait AccessToken
{
    private static $_getAccessTokenUri = 'cgi-bin/gettoken';

    public function getAccessToken()
    {
        $response = $this->get(self::$_getAccessTokenUri, [
            'query' => ['corpid' => $this->_corpId, 'corpsecret' => $this->_corpSecret]
        ]);
        return $response->json()['access_token'];
    }
}
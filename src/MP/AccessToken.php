<?php
namespace Xueba\WxApi\MP;

trait AccessToken
{
    private static $_getAccessTokenUri = 'cgi-bin/token';

    public function getAccessToken()
    {
        $response = $this->get(self::$_getAccessTokenUri, [
            'query' => ['grant_type' => 'client_credential', 'appid' => $this->_appid, 'secret' => $this->_secret]
        ]);
        return $response->json()['access_token'];
    }
}
<?php
namespace Xueba\WxApi\QY;

trait OAuth2
{
    private static $_getUserInfoUri = 'cgi-bin/user/getuserinfo';

    public function getUserInfo($code, $agentId)
    {
        $response = $this->get(self::$_getUserInfoUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'code' => $code, 'agentid' => $agentId],
        ]);
        return $response->json();
    }
}
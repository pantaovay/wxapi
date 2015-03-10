<?php
namespace Xueba\WxApi;

trait Basic
{
    private static $_getCallbackIpUri = 'cgi-bin/getcallbackip';

    public function getCallbackIp()
    {
        $response = $this->get(self::$_getCallbackIpUri, [
            'query' => ['access_token' => $this->getAccessToken()],
        ]);
        return $response->json()['ip_list'];
    }
}

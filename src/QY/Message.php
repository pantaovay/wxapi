<?php
namespace Xueba\WxApi\QY;

trait Message
{
    private static $_sendMessageUri = 'cgi-bin/message/send';

    public function sendMessage($jsonMessage)
    {
        $response = $this->post(self::$_sendMessageUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body'  => $jsonMessage,
        ]);

        return $response->json();
    }
}
<?php
namespace Xueba\WxApi;

use GuzzleHttp\Stream\Utils;

trait Media
{
    private static $_uploadMediaURI = 'cgi-bin/media/upload';
    private static $_downloadMediaURI = 'cgi-bin/media/get';

    public function uploadMedia($media, $type)
    {
        $media = Utils::create(Utils::open($media, 'r'));
        $response = $this->post(self::MEDIA_BASE_URL . '/' . self::$_uploadMediaURI, [
            'headers' => ['Content-Type' => 'multipart/form-data'],
            'query' => ['access_token' => $this->getAccessToken(), 'type' => $type],
            'body' => ['media' => $media]
        ]);

        return $response->json();
    }

    public function getMedia($mediaID)
    {
        $response = $this->get(self::MEDIA_BASE_URL . '/' . self::$_downloadMediaURI, [
            'query' =>  ['access_token' => $this->getAccessToken(), 'media_id' => $mediaID]
        ]);
        return $response->getBody();
    }
}

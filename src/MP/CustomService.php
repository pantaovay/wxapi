<?php
namespace Xueba\WxApi\MP;

use GuzzleHttp\Stream\Utils;

trait CustomService
{
    private static $_addKfAccountUri = 'customservice/kfaccount/add';
    private static $_updateKfAccountUri = 'customservice/kfaccount/update';
    private static $_deleteKfAccountUri = 'customservice/kfaccount/del';
    private static $_setKfAccountHeadImgUri = 'customservice/kfaccount/uploadheadimg';
    private static $_getKfListUri = 'cgi-bin/customservice/getkflist';
    private static $_sendKfMessageUri = 'cgi-bin/message/custom/send';

    public function addKfAccount($kfAccount, $nickName, $password = '')
    {
        return $this->_sendPost(self::$_addKfAccountUri, $kfAccount, $nickName, $password);
    }

    public function updateKfAccount($kfAccount, $nickName, $password = '')
    {
        return $this->_sendPost(self::$_updateKfAccountUri, $kfAccount, $nickName, $password);
    }

    public function deleteKfAccount($kfAccount, $nickName, $password = '')
    {
        return $this->_sendPost(self::$_deleteKfAccountUri, $kfAccount, $nickName, $password);
    }

    private function _sendPost($uri, $kfAccount, $nickName, $password)
    {
        $response = $this->post($uri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => json_encode([
                'kf_account' => $kfAccount,
                'nickname' => $nickName,
                'password' => $password,
            ], JSON_UNESCAPED_UNICODE)
        ]);
        return $response->json();
    }

    /**
     * 设置客服头像
     */
    public function setKfHeadImg($kfAccount, $imgPath)
    {
        $img = Utils::create(Utils::open($imgPath, 'r'));
        $response = $this->post(self::$_setKfAccountHeadImgUri, [
            'headers' => ['Content-Type' => 'multipart/form-data'],
            'query' => ['access_token' => $this->getAccessToken(), 'kf_account' => $kfAccount],
            'body' => ['media' => $img],
        ]);
        return $response->json();
    }

    public function getKfList()
    {
        $response = $this->get(self::$_getKfListUri, [
            'query' => ['access_token' => $this->getAccessToken()]
        ]);
        return $response->json()['kf_list'];
    }

    public function sendKfMessage($jsonMessage)
    {
        $response = $this->post(self::$_sendKfMessageUri, [
            'query' => ['access_token' => $this->getAccessToken()],
            'body' => $jsonMessage,
        ]);
        return $response->json();
    }
}
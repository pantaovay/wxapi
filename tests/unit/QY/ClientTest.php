<?php

class ClientTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Xueba\WxApi\QY\Client
     */
    protected $client;
    protected $token = 'lXN4xKUiSLomtn3Ia';
    protected $encodingAesKey = '3HEAqmLm3GC3IVftNQuf2Coxs3xHVNIZ4brUvA0f4Uh';
    protected $corpId = 'wx218c3a8f3d8918be';
    protected $corpSecret = 'aAu-Qz6nVy6r0YVhI1KfAGGjC2ftzlqFiWX4s2EvTmjbwAxw32oLyLmMn69DKaYg';
    protected $agentid = 5;
    protected $imageId = '1URdrsGXP_B4lodF-sBf06qr6YCxuHALq1uD0Z-_e95ax3jgHsNiKxDUhB6bqeSDh';
    protected $voiceId = '1dpU1WQBQ7iobfeHN5UCCf3r-ImsS6nQO3k9NFxWgeakkrWESoTh06wxbX7X7gSor274s08X9lNYh-JpXyrZbgw';
    protected $toUser = 'pantaovay';

    protected function _before()
    {
        $this->client = new \Xueba\WxApi\QY\Client($this->corpId, $this->corpSecret, $this->token, $this->encodingAesKey);
    }

    protected function _after()
    {
    }

    public function testGetAccessToken()
    {
        $accessToken = $this->client->getAccessToken();
        codecept_debug($accessToken);
        $this->tester->assertEquals(64, strlen($accessToken));
        $this->tester->assertEquals($accessToken, $this->client->getAccessToken());
    }

    public function testSendMessage()
    {
        $test = function($message) {
            $response = $this->client->sendMessage($message);
            codecept_debug($response);
            $this->tester->assertEquals(0, $response['errcode']);
        };
        $messages = array(
            'file' => \Xueba\WxApi\QY\Message\Initiative\Image::getJson($this->agentid, $this->imageId, $this->toUser),
            'image' => \Xueba\WxApi\QY\Message\Initiative\Image::getJson($this->agentid, $this->imageId, $this->toUser),
            'text' => \Xueba\WxApi\QY\Message\Initiative\Text::getJson($this->agentid, '测试测试', $this->toUser),
            'voice' => \Xueba\WxApi\QY\Message\Initiative\Voice::getJson($this->agentid, $this->voiceId, $this->toUser),
            'news' => \Xueba\WxApi\QY\Message\Initiative\News::getJson(
                $this->agentid,
                [['title' => 'Young', 'description' => '专为大学生设计的交友APP', 'url' => 'http://young.xueba.mobi', 'picurl' => 'http://frontend.xueba.mobi/young/img/pc/qr_code.png']],
                $this->toUser
            ),
        );
        foreach ($messages as $message)
        {
            $test($message);
        }
    }

    public function testGetReplyEchoStr()
    {
        $encodingAesKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
        $token = "QDG6eK";
        $corpId = "wx5823bf96d3bd56c7";
        $client = new \Xueba\WxApi\QY\Client($corpId, '', $token, $encodingAesKey);
        $sVerifyMsgSig = "5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3";
        $sVerifyTimeStamp = "1409659589";
        $sVerifyNonce = "263014780";
        $sVerifyEchoStr = "P9nAzCzyDtyTWESHep1vC5X9xho/qYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp+4RPcs8TgAE7OaBO+FZXvnaqQ==";

        $replyEchoStr = $client->getReplyEchoStr($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr);
        codecept_debug($replyEchoStr);
        $this->tester->assertNotEmpty($replyEchoStr);
    }

    public function testEncryptDecryptMsg()
    {
        $encodingAesKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
        $token = "QDG6eK";
        $corpId = "wx5823bf96d3bd56c7";
        $client = new \Xueba\WxApi\QY\Client($corpId, '', $token, $encodingAesKey);

        $sReqMsgSig = "477715d11cdb4164915debcba66cb864d751f3e6";
        $sReqTimeStamp = "1409659813";
        $sReqNonce = "1372623149";
        $sReqData = "<xml><ToUserName><![CDATA[wx5823bf96d3bd56c7]]></ToUserName><Encrypt><![CDATA[RypEvHKD8QQKFhvQ6QleEB4J58tiPdvo+rtK1I9qca6aM/wvqnLSV5zEPeusUiX5L5X/0lWfrf0QADHHhGd3QczcdCUpj911L3vg3W/sYYvuJTs3TUUkSUXxaccAS0qhxchrRYt66wiSpGLYL42aM6A8dTT+6k4aSknmPj48kzJs8qLjvd4Xgpue06DOdnLxAUHzM6+kDZ+HMZfJYuR+LtwGc2hgf5gsijff0ekUNXZiqATP7PF5mZxZ3Izoun1s4zG4LUMnvw2r+KqCKIw+3IQH03v+BCA9nMELNqbSf6tiWSrXJB3LAVGUcallcrw8V2t9EL4EhzJWrQUax5wLVMNS0+rUPA3k22Ncx4XXZS9o0MBH27Bo6BpNelZpS+/uh9KsNlY6bHCmJU9p8g7m3fVKn28H3KDYA5Pl/T8Z1ptDAVe0lXdQ2YoyyH2uyPIGHBZZIs2pDBS8R07+qN+E7Q==]]></Encrypt><AgentID><![CDATA[218]]></AgentID></xml>";
        $sMsg = $client->decryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData);
        codecept_debug($sMsg);
        $this->tester->assertNotEmpty($sMsg);

        $sRespData = "<xml><ToUserName><![CDATA[mycreate]]></ToUserName><FromUserName><![CDATA[wx5823bf96d3bd56c7]]></FromUserName><CreateTime>1348831860</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[this is a test]]></Content><MsgId>1234567890123456</MsgId><AgentID>128</AgentID></xml>";
        $sEncryptMsg = $client->encryptMsg($sRespData, $sReqTimeStamp, $sReqNonce);
        codecept_debug($sEncryptMsg);
        $this->tester->assertNotEmpty($sEncryptMsg);
    }

    public function testMenu()
    {
        $buttons = array();
        $button = new \Xueba\WxApi\QY\Button('打开网址');
        $button->addSubButton(new \Xueba\WxApi\QY\Button('百度', 'view', '', 'http://baidu.com'));
        $button->addSubButton(new \Xueba\WxApi\QY\Button('360', 'view', '', 'http://360.com'));
        $buttons[] = $button;
        $button = new \Xueba\WxApi\QY\Button('位置选择', 'location_select', 'poi_selete');
        $buttons[] = $button;

        $result = $this->client->createMenu($buttons, $this->agentid);
        codecept_debug($result);
        $result = $this->client->getMenu($this->agentid);
        codecept_debug($result);
        $this->tester->assertEquals('打开网址', $result['menu']['button'][0]['name']);
        $result = $this->client->deleteMenu($this->agentid);
        codecept_debug($result);
    }
}
<?php

class ClientText extends \Codeception\TestCase\Test
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

    public function testEncryptMsg()
    {
        $sVerifyTimeStamp = "1409659589";
        $sVerifyNonce = "263014780";

        $sMsg = <<<XML
<xml>
<ToUserName><![CDATA[mycreate]]></ToUserName>
<FromUserName><![CDATA[wx5823bf96d3bd56c7]]></FromUserName>
<CreateTime>1348831860</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[this is a test]]></Content>
<MsgId>1234567890123456</MsgId>
<AgentID>128</AgentID>
</xml>
XML;

        $sEncryptMsg = $this->client->encryptMsg($sMsg, $sVerifyTimeStamp, $sVerifyNonce);
        codecept_debug($sEncryptMsg);
        $this->tester->assertNotEmpty($sEncryptMsg);

        $result = array();
        preg_match("/<MsgSignature><\!\[CDATA\[(.*?)\]\]><\/MsgSignature>/", $sEncryptMsg, $result);
        $sVerifyMsgSig = $result[1];
        codecept_debug($sVerifyMsgSig);

        // 解密
        $this->tester->assertEquals($sMsg, $this->client->decryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sEncryptMsg));
    }
}
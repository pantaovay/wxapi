<?php

class PassiveTest extends \Codeception\TestCase\Test
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

    protected function _before()
    {
        $this->client = new \Xueba\WxApi\QY\Client($this->corpId, $this->corpSecret, $this->token, $this->encodingAesKey);
    }

    protected function _after()
    {
    }

    public function testReceiveToArray()
    {
        $textXml = <<<XML
<xml><ToUserName><![CDATA[wx218c3a8f3d8918be]]></ToUserName>
<FromUserName><![CDATA[pantaovay]]></FromUserName>
<CreateTime>1425621475</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[测试]]></Content>
<MsgId>4376592466560680094</MsgId>
<AgentID>5</AgentID>
</xml>
XML;
        $receiveObj = new \Xueba\WxApi\Message\Passive\Receive($textXml);
        $this->tester->assertEquals([
            'ToUserName' => 'wx218c3a8f3d8918be',
            'FromUserName' => 'pantaovay',
            'CreateTime' => '1425621475',
            'MsgType' => 'text',
            'Content' => '测试',
            'MsgId' => '4376592466560680094',
            'AgentID' => '5'
        ], $receiveObj->toArray());
        $this->tester->assertEquals('5', $receiveObj->toArray('AgentID'));
    }
}

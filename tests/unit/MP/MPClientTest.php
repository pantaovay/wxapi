<?php

class MPClientTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Xueba\WxApi\MP\Client
     */
    protected $client;
    protected $token = 'lXN4xKUiSLomtn3Ia';
    protected $encodingAesKey = '3HEAqmLm3GC3IVftNQuf2Coxs3xHVNIZ4brUvA0f4Uh';
    protected $appId = 'wx2bab996838f3f639';
    protected $appSecret = '73329f78e2ae9d0fb348f3f784e79f5a';
    protected $weixinId = 'gh_184f85fa34fd';

    protected $signature = '28f4aaa727e4aabd815e12a78c05941a30e43059';
    protected $timestamp = '1425957952';
    protected $nonce = '802736895';

    protected function _before()
    {
        $this->client = new \Xueba\WxApi\MP\Client($this->appId, $this->appSecret, $this->token, $this->encodingAesKey);
    }

    protected function _after()
    {
    }

    public function testCheckSignature()
    {
        $this->tester->assertTrue($this->client->checkSignature($this->signature, $this->timestamp, $this->nonce));
    }

    public function testGetAccessToken()
    {
        $accessToken = $this->client->getAccessToken();
        codecept_debug($accessToken);
        $this->tester->assertNotEmpty($accessToken);
    }

    public function testGetCallbackIp()
    {
        codecept_debug($this->client->getCallbackIp());
        $this->tester->assertNotEmpty($this->client->getCallbackIp());
    }

    public function testMedia()
    {
        $filepath = __DIR__ . '/../../_data/test.jpg';
        $response = $this->client->uploadMedia($filepath, 'image');
        codecept_debug($response);
        $this->tester->assertEquals('image', $response['type']);
        $response = $this->client->getMedia($response['media_id']);
        codecept_debug($response);
        $this->tester->assertEquals(filesize($filepath), $response->getSize());
    }

    public function testMenu()
    {
        $buttons = array();
        $button = new \Xueba\WxApi\Button('打开网址');
        $button->addSubButton(new \Xueba\WxApi\Button('百度', 'view', '', 'http://baidu.com'));
        $button->addSubButton(new \Xueba\WxApi\Button('360', 'view', '', 'http://360.com'));
        $buttons[] = $button;
        $button = new \Xueba\WxApi\Button('位置选择', 'location_select', 'poi_selete');
        $buttons[] = $button;

        $result = $this->client->createMenu($buttons);
        codecept_debug($result);
        $result = $this->client->getMenu();
        codecept_debug($result);
        $this->tester->assertEquals('打开网址', $result['menu']['button'][0]['name']);
        $result = $this->client->deleteMenu();
        codecept_debug($result);
    }

    public function testCustomService()
    {
        $this->client->addKfAccount('test@' . $this->weixinId, 'test', md5('123'));
        codecept_debug($this->client->getKfList());
        codecept_debug($this->client->deleteKfAccount('test@' . $this->weixinId, 'test', md5('123')));
    }
}
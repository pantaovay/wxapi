<?php
namespace Xueba\WxApi;
use GuzzleHttp\Event\CompleteEvent;

trait Client
{
    protected function setCompleteEvent()
    {
        $this->getEmitter()->on('complete', function (CompleteEvent $event) {
            $response = $event->getResponse();
            try
            {
                $result = $response->json();
            }
            catch (\Exception $e)
            {
                return;
            }
            if (isset($result['errcode']) && $result['errcode'] != 0)
            {
                throw new Exception($result['errmsg'], $result['errcode']);
            }
        });
    }
}
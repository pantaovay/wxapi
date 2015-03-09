<?php
namespace Xueba\WxApi\QY;

trait Menu
{
    private static $_createMenuUri = 'cgi-bin/menu/create';
    private static $_deleteMenuUri = 'cgi-bin/menu/delete';
    private static $_getMenuUri = 'cgi-bin/menu/get';

    public function createMenu($buttons, $agentId)
    {
        $menu = array(
            'button' => array(),
        );
        foreach ($buttons as $button)
        {
            $menu['button'][] = $button->toArray();
        }

        $response = $this->post(self::$_createMenuUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'agentid' => $agentId],
            'body'  => json_encode($menu, JSON_UNESCAPED_UNICODE),
        ]);
        return $response->json();
    }

    public function deleteMenu($agentId)
    {
        $response = $this->get(self::$_deleteMenuUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'agentid' => $agentId],
        ]);
        return $response->json();
    }

    public function getMenu($agentId)
    {
        $response = $this->get(self::$_getMenuUri, [
            'query' => ['access_token' => $this->getAccessToken(), 'agentid' => $agentId],
        ]);
        return $response->json();
    }
}
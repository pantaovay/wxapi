<?php
namespace Xueba\WxApi\QY;

use Xueba\WxApi\Exception;

class Button
{
    private $_name;
    private $_type;
    private $_key;
    private $_url;
    private $_subButton;

    private static $_types = array('click', 'view', 'scancode_push', 'scancode_waitmsg', 'pic_sysphoto', 'pic_photo_or_album', 'pic_weixin', 'location_select');

    public function __construct($name, $type = '', $key = '', $url = '')
    {
        if (!empty($type))
        {
            if (!in_array($type, self::$_types))
            {
                throw new Exception('Menu type not exist');
            }
            if ($type != 'view' && empty($key))
            {
                throw new Exception('Menu type needs key');
            }
            if ($type == 'view' && empty($url))
            {
                throw new Exception('Menu type view needs url');
            }
        }
        $this->_name = $name;
        $this->_type = $type;
        $this->_key = $key;
        $this->_url = $url;
        $this->_subButton = array();
    }

    public function addSubButton(self $button)
    {
        $this->_subButton[] = $button;
    }

    public function toArray()
    {
        $button = array(
            'name' => $this->_name,
            'type' => $this->_type,
            'key' => $this->_key,
            'url' => $this->_url,
            'sub_button' => array(),
        );
        if (!empty($this->_subButton))
        {
            foreach ($this->_subButton as $subButton)
            {
                $button['sub_button'][] = $subButton->toArray();
            }
        }

        return $button;
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
<?php
namespace Xueba\WxApi\QY\AddressBook;

class User
{
    private $_userId;
    private $_name;
    private $_department;
    private $_position;
    private $_mobile;
    private $_email;
    private $_weixinId;
    private $_extAttr;

    public function __construct($userId, $name, $department = '', $position = '', $mobile = '', $email = '', $weixinId = '', array $extAttr = array())
    {
        $this->_userId = $userId;
        $this->_name = $name;
        $this->_department = $department;
        $this->_position = $position;
        $this->_mobile = $mobile;
        $this->_email = $email;
        $this->_weixinId = $weixinId;
        $this->_extAttr = $extAttr;
    }

    public function toJson()
    {
        return json_encode([
            'userid' => $this->_userId,
            'name' => $this->_name,
            'department' => $this->_department,
            'position' => $this->_position,
            'mobile' => $this->_mobile,
            'email' => $this->_email,
            'weixinid' => $this->_weixinId,
            'extAttr' => $this->_extAttr,
        ], JSON_UNESCAPED_UNICODE);
    }
}

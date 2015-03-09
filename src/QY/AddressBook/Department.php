<?php
namespace Xueba\WxApi\QY\AddressBook;

class Department
{
    private $_name;
    private $_parentId;
    private $_order;
    private $_id;

    public function __construct($name, $parentId, $order = '', $id = '')
    {
        $this->_name = $name;
        $this->_parentId = $parentId;
        $this->_order = $order;
        $this->_id = $id;
    }

    public function toJson()
    {
        return json_encode([
            'name' => $this->_name,
            'parentid' => $this->_parentId,
            'order' => $this->_order,
            'id' => $this->_id,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function serParentId($parentId)
    {
        $this->_parentId = $parentId;
    }

    public function setOrder($order)
    {
        $this->_order = $order;
    }
}

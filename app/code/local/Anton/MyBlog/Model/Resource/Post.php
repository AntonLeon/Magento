<?php

class Anton_MyBlog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('myblog/post', 'request_id');
    }
}
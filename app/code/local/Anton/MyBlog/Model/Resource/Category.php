<?php

class Anton_MyBlog_Model_Resource_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('myblog/category', 'post_ids');
    }
}
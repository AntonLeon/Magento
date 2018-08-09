<?php

class Anton_MyBlog_Model_Post extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('myblog/post');
    }
}
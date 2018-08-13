<?php

class Anton_MyBlog_Block_Adminhtml_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function _construct()
    {
        $this->_blockGroup = 'myblog';
        $this->_controller = 'adminhtml_post';
        $this->_headerText = 'Post request';

        parent::_construct();
        $this->removeButton('add');
    }
}
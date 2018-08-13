<?php

class Anton_MyBlog_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function _construct()
    {
        $this->_blockGroup = 'myblog';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = 'Category request';

        parent::_construct();
        $this->removeButton('add');
    }
}
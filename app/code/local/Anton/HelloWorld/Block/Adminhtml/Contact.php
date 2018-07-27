<?php

class Anton_HelloWorld_Block_Adminhtml_Contact extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function _construct()
    {
        $this->_blockGroup = 'helloworld';
        $this->_controller = 'adminhtml_contact';
        $this->_headerText = 'Contacts request';

        parent::_construct();
        $this->_removeButton('add');
    }
}
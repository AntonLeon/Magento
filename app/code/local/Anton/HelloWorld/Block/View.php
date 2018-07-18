<?php

class Anton_HelloWorld_Block_View extends Mage_Core_Block_Template
{
    public function getRequestedRecord()
    {
        return Mage::getModel('helloworld/contact')->getCollection();
    }
}
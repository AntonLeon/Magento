<?php

class Anton_HelloWorld_Model_Contact extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('helloworld/contact');
    }
}
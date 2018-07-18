<?php

class Anton_HelloWorld_Block_View extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        return Mage::getStoreConfig('helloworld/settings/raw_text');
    }
}
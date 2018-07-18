<?php

class Anton_HelloWorld_Block_View extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        return 'Hello world!';
    }
}
<?php

class Anton_HelloWorld_Model_Observer
{
    public function saveRequest($event)
    {
        $data = $event->getData('object')->getData();
        $event->getData('objeect')->setData($data) . ' Made in China';

    }
}
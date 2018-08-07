<?php

class Anton_HelloWorld_Model_Observer
{
    public function saveRequest($event)
    {
            $model = Mage::getModel('helloworld/contact');
            $model->setName($event->getData('name')->getData())
                ->setComment($event->getData('comment')->getData() . ' Made in China')
                ->setTypeMessage($event->getData('email')->getData())
                ->setImage($event->getData('telephone')->getData())
                ->save();
    }
}
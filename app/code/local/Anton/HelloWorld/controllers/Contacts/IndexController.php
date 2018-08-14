<?php

require_once Mage::getModuleDir('controllers', 'Mage_Contacts') . DS . 'IndexController.php';

class Anton_HelloWorld_Contacts_IndexController extends Mage_Contacts_IndexController
{
    public function postAction()
    {
        parent::postAction();
        if ($this->getRequest()->getPost()) {
            $model = Mage::getModel('helloworld/contact');
            $model->setName($this->getRequest()->getPost('name'))
                ->setComment($this->getRequest()->getPost('comment'))
                ->setTypeMessage($this->getRequest()->getPost('telephone'))
                ->setImage($this->getRequest()->getPost('email'))
                ->save();
        }
    }
}
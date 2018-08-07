<?php

require_once Mage::getModuleDir('controllers', 'Mage_Contacts') . DS . 'IndexController.php';

class Anton_HelloWorld_Contacts_IndexController extends Mage_Contacts_IndexController
{
    public function postAction()
    {
        Mage::dispatchEvent('cms_save_contact_request', array(
            'name' => $this->getRequest()->getPost('name'),
            'comment' => $this->getRequest()->getPost('comment'),
            'email' => $this->getRequest()->getPost('email')
            ));
        //var_dump($this->getRequest()->getPost());
        return $this->_redirect('*/*/');
    }
}
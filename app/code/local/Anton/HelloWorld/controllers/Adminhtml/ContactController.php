<?php

class Anton_HelloWorld_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Contact requests'))->_title($this->__('My Contact'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/my_contacts');
        $this->_addContent($this->getLayout()->createBlock('helloworld/adminhtml_contact'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid')->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'contacts.csv';
        $grid = $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportExcelAction()
    {
        $fileName = 'contacts.xml';
        $grid = $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Contact Request'));
        $id = $this->getRequest()->getParam('request_id');
        $model = Mage::getModel('helloworld/contact');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helloworld')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Request'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (! empty($data)) {
            $model->setData($data);
        }

        Mage::register('contact_request', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('helloworld/adminhtml_contact_edit'));
        $this->_setActiveMenu('cms/my_contacts')
            ->_addBreadcrumb($id ? Mage::helper('helloworld')->__('Edit Request') : Mage::helper('helloworld')->__('New Request'), $id ? Mage::helper('helloworld')->__('
            Edit Request') : Mage::helper('helloworld')->__('New Request'))
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('helloworld/contact');

            $model->setRequestId($data['request_id'])
                ->setName($data['name'])
                ->setComment($data['comment'])
                ->save();

            Mage::getSingleton('adminhtml/session')->addSuccess('Item was successfully saved');
            Mage::getSingleton('adminhtml/session')->setmodel(false);

            $this->_redirect('*/*/');
            return;
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('request_id')) {
            Mage::getModel('helloworld/contact')->setId($id)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess('Comment was deleted successfuly');
        }

        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/my_contacts');
    }
}
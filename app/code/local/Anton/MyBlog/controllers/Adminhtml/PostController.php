<?php

class Anton_MyBlog_Adminhtml_PostController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Post requests'))->_title($this->__('Posts'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/my_posts');
        $this->_addContent($this->getLayout()->createBlock('myblog/adminhtml_post'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('myblog/adminhtml_post_grid')->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'posts.csv';
        $grid = $this->getLayout()->createBlock('myblog/adminhtml_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportExcelAction()
    {
        $fileName = 'posts.xml';
        $grid = $this->getLayout()->createBlock('myblog/adminhtml_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Post Request'));
        $id = $this->getRequest()->getParam('post_id');
        $model = Mage::getModel('myblog/post');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('myblog')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Request'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (! empty($data)) {
            $model->setData($data);
        }

        Mage::register('post_request', $model);


        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('myblog/adminhtml_post_edit'));
        $this->_setActiveMenu('cms/my_posts')
            ->_addBreadcrumb($id ? Mage::helper('myblog')->__('Edit Request') : Mage::helper('myblog')->__('New Request'), $id ? Mage::helper('myblog')->__('
            Edit Request') : Mage::helper('myblog')->__('New Request'))
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('myblog/post');
            $categoryModel = Mage::getModel('myblog/category');

            $model->setRequestId($data['post_id'])
                ->setName($data['name'])
                ->setContent($data['content'])
                ->setShortDescription($data['description'])
                ->setStatus($data['status'])
                ->save();
            $categoryModel->setPostIds($data['post_id'])
                ->setName($data['category'])
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
        if ($id = $this->getRequest()->getParam('post_id')) {
            Mage::getModel('myblog/post')->setId($id)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess('Comment was deleted successfuly');
        }

        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/my_posts');
    }
}
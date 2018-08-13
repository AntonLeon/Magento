<?php

class Anton_MyBlog_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Category requests'))->_title($this->__('Categories'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/my_categories');
        $this->_addContent($this->getLayout()->createBlock('myblog/adminhtml_category'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('myblog/adminhtml_category_grid')->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'categories.csv';
        $grid = $this->getLayout()->createBlock('myblog/adminhtml_category_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportExcelAction()
    {
        $fileName = 'categories.xml';
        $grid = $this->getLayout()->createBlock('myblog/adminhtml_category_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Category Request'));
        $id = $this->getRequest()->getParam('category_id');
        $model = Mage::getModel('myblog/category');

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

        Mage::register('category_request', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('myblog/adminhtml_category_edit'));
        $this->_setActiveMenu('cms/my_categories')
            ->_addBreadcrumb($id ? Mage::helper('myblog')->__('Edit Request') : Mage::helper('myblog')->__('New Request'), $id ? Mage::helper('myblog')->__('
            Edit Request') : Mage::helper('myblog')->__('New Request'))
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('myblog/category');

            $model->setRequestId($data['category_id'])
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->save();

            $helper = Mage::helper('myblog');
            $id = $model->getId();

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $uploader->save($helper->getImagePath($id));

                $model->setImage($helper->getImagePath($id))->save();

            } else {
                if (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                    @unlink($helper->getImagePath($id));
                }
            }

            Mage::getSingleton('adminhtml/session')->addSuccess('Item was successfully saved');
            Mage::getSingleton('adminhtml/session')->setmodel(false);

            $this->_redirect('*/*/');
            return;
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('category_id')) {
            Mage::getModel('myblog/category')->setId($id)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess('Comment was deleted successfuly');
        }

        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/my_categories');
    }
}
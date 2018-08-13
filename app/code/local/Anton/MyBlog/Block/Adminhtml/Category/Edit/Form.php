<?php

class Anton_MyBlog_Block_Adminhtml_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('category_request');
        $this->setTitle(Mage::helper('myblog')->__('Request info'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('category_request');

        $form = new Varien_Data_Form(
            ['id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post']
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => Mage::helper('myblog')->__('General Information'),
            'class' => 'fieldset-wide',
        ]);

        if ($model->getRequestId()) {
            $fieldset->addField('category_id', 'hidden', [
                'name' => 'category_id',
            ]);
        }

        $fieldset->addField('name', 'text', [
            'name' => 'name',
            'label' => Mage::helper('myblog')->__('Category Name'),
            'title' => Mage::helper('myblog')->__('Category Name'),
            'required' => true,
        ]);

        $fieldset->addField('image', 'image', [
            'name' => 'image',
            'label' => Mage::helper('myblog')->__('Upload Image'),
        ]);

        $fieldset->addField('description', 'editor', [
            'name' => 'description',
            'label' => Mage::helper('myblog')->__('Category Description'),
            'title' => Mage::helper('myblog')->__('Category Description'),
            'style' => 'height:36em',
            'required' => true,
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

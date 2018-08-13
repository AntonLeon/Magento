<?php

class Anton_MyBlog_Block_Adminhtml_Post_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('post_request');
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
        $model = Mage::registry('post_request');
        $categoryModel = Mage::getModel('myblog/category')->getCollection();

        $form = new Varien_Data_Form(
            ['id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post']
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => Mage::helper('myblog')->__('General Information'),
            'class' => 'fieldset-wide',
        ]);

        if ($model->getRequestId()) {
            $fieldset->addField('post_id', 'hidden', [
                'name' => 'post_id',
            ]);
        }

        $fieldset->addField('status', 'select', [
            'name' => 'status',
            'label' => Mage::helper('myblog')->__('Post Status'),
            'title' => Mage::helper('myblog')->__('Post Status'),
            'values' => array(
                '1' => 'Enabled',
                '0' => 'Disabled',
            ),
        ]);

        $categories = [];
        foreach ($categoryModel as $val) {
            $categories[$val->getName()] = $val->getName();
        }

        $fieldset->addField('category', 'select', [
            'name' => 'category',
            'label' => Mage::helper('myblog')->__('Post Category'),
            'title' => Mage::helper('myblog')->__('Post Category'),
            'values' => $categories
        ]);


        $fieldset->addField('name', 'text', [
            'name' => 'name',
            'label' => Mage::helper('myblog')->__('Post Name'),
            'title' => Mage::helper('myblog')->__('Post Name'),
            'required' => true,
        ]);

        $fieldset->addField('content', 'editor', [
            'name' => 'content',
            'label' => Mage::helper('myblog')->__('Post Content'),
            'title' => Mage::helper('myblog')->__('Post Content'),
            'style' => 'height:36em',
            'required' => true,
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ]);

        $fieldset->addField('description', 'editor', [
            'name' => 'description',
            'label' => Mage::helper('myblog')->__('Category Description'),
            'title' => Mage::helper('myblog')->__('Category Description'),
            'required' => true,
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php

class Anton_HelloWorld_Block_Adminhtml_Contact_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('contact_request');
        $this->setTitle(Mage::helper('helloworld')->__('Request info'));
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
        $model = Mage::registry('contact_request');

        $form = new Varien_Data_Form(
            ['id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post']
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => Mage::helper('helloworld')->__('General Information'),
            'class' => 'fieldset-wide',
        ]);

        if ($model->getRequestId()) {
            $fieldset->addField('request_id', 'hidden', [
                'name' => 'request_id',
            ]);
        }

        $fieldset->addField('name', 'text', [
            'name' => 'name',
            'label' => Mage::helper('helloworld')->__('Contact Name'),
            'title' => Mage::helper('helloworld')->__('Contact Name'),
            'required' => true,
        ]);

        $fieldset->addField('image', 'image', [
            'name' => 'image',
            'label' => Mage::helper('helloworld')->__('Upload Image'),
        ]);

        $fieldset->addField('type_message', 'select', [
            'name' => 'type_message',
            'label' => Mage::helper('helloworld')->__('Type of Message'),
            'title' => Mage::helper('helloworld')->__('Type of Message'),
            'required' => true,
            'values' => array(
                'Жалоба' => 'Жалоба', 
                'Предложение' => 'Предложение',
                'Пожелание' => 'Пожелание', 
                'Благодарность' => 'Благодарность'
            ),
        ]);


        $fieldset->addField('comment', 'editor', [
            'name' => 'comment',
            'label' => Mage::helper('helloworld')->__('Comment'),
            'title' => Mage::helper('helloworld')->__('Comment'),
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
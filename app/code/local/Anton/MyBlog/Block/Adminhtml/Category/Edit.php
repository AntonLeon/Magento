<?php

class Anton_MyBlog_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function _construct()
    {
        $this->_objectId = 'category_id';
        $this->_blockGroup = 'myblog';
        $this->_controller = 'adminhtml_category';
        $this->_mode = 'edit';

        parent::_construct();

        $this->_updateButton('save', 'label', Mage::helper('myblog')->__('Save Request'));
        $this->_updateButton('delete', 'label',  Mage::helper('myblog')->__('Delete Request'));

        $this->addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
                function toggleEditor() {
                        if (tinyMCE.getInstanceById('block_content') == null) {
                            tinyMCE.execCommand('mceAddControl', false, 'block_content');
                        } else {
                            tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                        }
                    }

                    function saveAndContinueEdit(){
                        editForm.submit($('edit_form').action+'back/edit/');
                    }
            ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('category_request')->getId()) {
            return Mage::helper('myblog')->__("Edit Request # %s", $this->escapeHtml(Mage::registry('category_request')->getId()));
        } else {
            return Mage::helper('myblog')->__('New Request');
        }
    }

}
<?php

class Anton_HelloWorld_Block_Adminhtml_Contact_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('my_contact_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('helloworld/contact_collection');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('helloworld');

        $this->addColumn('id', [
            'header' => $helper->__('Request #'),
            'index' => 'request_id',
        ]);

        $this->addColumn('name', [
            'header' => $helper->__('Contact Name'),
            'type' => 'text',
            'index' => 'name',
        ]);

        $this->addColumn('type_message', [
            'header' => $helper->__('Type of Message'),
            'type' => 'text',
            'index' => 'type_message',
        ]);

        $this->addColumn('image', [
            'header' => $helper->__('Image'),
            'type' => 'text',
            'index' => 'image',
        ]);


        $this->addExportType('*/*/exportCsv', 'CSV');
        $this->addExportType('*/*/exportExcel', 'Excel');

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
      return $this->getUrl('*/*/edit', ['request_id' => $row->getId()]);
    }

    public function getGridUrl($params = [])
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
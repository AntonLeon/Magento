<?php

class Anton_MyBlog_Block_Adminhtml_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('my_post_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('myblog/post_collection');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('myblog');

        $this->addColumn('id', [
            'header' => $helper->__('Request #'),
            'index' => 'post_id',
        ]);

        $this->addColumn('name', [
            'header' => $helper->__('Post Name'),
            'type' => 'text',
            'index' => 'name',
        ]);

        $this->addColumn('description', [
            'header' => $helper->__('Post Description'),
            'type' => 'text',
            'index' => 'short_description',
        ]);

        $this->addColumn('status', [
            'header' => $helper->__('Status'),
            'type' => 'text',
            'index' => 'status',
        ]);


        $this->addExportType('*/*/exportCsv', 'CSV');
        $this->addExportType('*/*/exportExcel', 'Excel');

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['post_id' => $row->getId()]);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
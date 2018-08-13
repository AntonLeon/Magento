<?php

class Anton_MyBlog_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('my_category_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('myblog/category_collection');
        $collection->getSelect()->group('name');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('myblog');

        $this->addColumn('id', [
            'header' => $helper->__('Request #'),
            'index' => 'category_id',
        ]);

        $this->addColumn('name', [
            'header' => $helper->__('Category Name'),
            'type' => 'text',
            'index' => 'name',
        ]);

        $this->addColumn('description', [
            'header' => $helper->__('Category Description'),
            'type' => 'text',
            'index' => 'description',
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
        return $this->getUrl('*/*/edit', ['category_id' => $row->getId()]);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
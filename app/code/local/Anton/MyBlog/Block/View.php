<?php

class Anton_MyBlog_Block_View extends Mage_Core_Block_Template
{
    public function getCategoriesCollection()
    {
        $collection =  Mage::getModel('myblog/category')->getCollection();
        $collection->getSelect()->group('name');

        return $collection;
    }

    public function getCategory($category)
    {
        $collection = Mage::getModel('myblog/category')->getCollection();
        $collection->getSelect()->group('name');
        $collection->addFieldToFilter('name', $category);
        $collection->getData();

        $coll = [];
        foreach ($collection as $val) {
                $coll['name'] = $val->getName();
                $coll['description'] = $val->getDesription();
                $coll['image'] = $val->getImage();
        }

        return $coll;
    }

    public function getPosts($name)
    {
        $posts = Mage::getModel('myblog/category')->getCollection();
        $posts->addFieldToFilter('name', "$name");
        //$posts->getSelect()->order('DESC');

        return $posts;
    }

    public function getPostNameById($id)
    {
        $post = Mage::getModel('myblog/post')->getCollection()
            ->addFieldToFilter('post_id', $id)
            ->addFieldToFilter('status', 1)
            ->getData();

        return $post[0]['name'];
    }

    public function getPostById($id)
    {
        $post = Mage::getModel('myblog/post')
            ->addFieldToFilter('post_id', $id)
            ->addFieldToFilter('status', 1);

        return $post;
    }

    public function getPostsByCategory($id)
    {
        return Mage::getModel('myblog/post')->getCollection()
            ->join('myblog/category', 'post_id=post_ids', 'name as category_name')
            ->addFieldToFilter('post_id', $id);
    }
}
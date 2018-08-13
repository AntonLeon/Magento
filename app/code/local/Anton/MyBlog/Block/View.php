<?php

class Anton_MyBlog_Block_View extends Mage_Core_Block_Template
{
    public function getCategoriesCollection()
    {
        $collection =  Mage::getModel('myblog/category')->getCollection();
        $collection->getSelect()->group('name');
        return $collection;
    }

    public function getPosts($name)
    {
        $posts = Mage::getModel('myblog/category')->getCollection();
        //$posts->join('myblog/post', 'post_ids=post_id', 'name as post_name');
        $posts->addFieldToFilter('name', "$name");
//        $posts->addAttributeToFilter(
//            array('name' => "$name"),
//            array('status' => 1)
//        );


        return $posts;
    }

    public function getPostById($id)
    {
        $post = Mage::getModel('myblog/post')->getCollection();
        $post->addFieldToFilter('post_id', $id);

        return $post;
    }

    public function getPostsByCategory($id)
    {
        return Mage::getModel('myblog/post')->getCollection()
            ->join('myblog/category', 'post_id=post_ids', 'name as category_name')
            ->addFieldToFilter('post_id', $id)
            ->getData();
    }
}
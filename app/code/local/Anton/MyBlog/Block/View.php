<?php

class Anton_MyBlog_Block_View extends Mage_Core_Block_Template
{
    public function getCategoriesCollection()
    {
        return Mage::getModel('myblog/category')->getCollection();
    }

    public function getPostsId($name)
    {
        $posts = Mage::getModel('myblog/category')->getCollection();
        $posts->addFieldToFilter('name', "$name");
        $posts->joinTable('myblog_post', 'post_id=post_ids', null, 'left');
        //$posts->getSelect()->join('post', 'category.post_ids=post.post_id', array('name'));
        return $posts;
    }

    public function getPostName($id)
    {
        $post = Mage::getModel('myblog/post')->load(1);
        //$post->addFieldToFilter('post_ids', $id);
        return $post;

    }

    public function getPostsByCategory($id)
    {
        return Mage::getModel('myblog/post')->getData();
    }
}
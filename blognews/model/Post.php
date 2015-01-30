<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Post
 *
 * @author 1130619373
 */
class Post {
    var $title;
    var $content;
    var $post_date;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getPost_date() {
        return $this->post_date;
    }

    public function setPost_date($post_date) {
        $this->post_date = $post_date;
    }

    
}
?>

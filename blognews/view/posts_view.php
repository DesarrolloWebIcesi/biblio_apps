<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<?php
include_once '../control/PostList.php';
include_once '../model/Post.php';

$post_ctd=(isset ($_POST['ctd']))? $_POST['ctd']:0;
$post_q=($post_ctd>0)? $post_ctd:2;
$posts=postList($post_q);

//echo '-rpost'.$post_ctd.'<br/>';
//echo '-qpost'.$post_q.'<br/>';
//echo '-post'.count($posts).'<br/>';

if(count($posts)>0){   
    $i=0;
    while($i<$post_q && $i<count($posts)){
        $post=$posts[$i];
?>
<div class="blog_post">
    <div id="post_header">
        <div class="post_title"><h3><?php echo $post->getTitle();?></h3></div>
        <div class="post_date"><?php echo $post->getPost_date();?></div>
    </div>
    <div class="post_content"><?php echo $post->getContent();?></div>
</div>
<?php
    $i=$i+1;
    }
}else{
    echo '<span>No hay Post para mostrar</span>';
}
?>

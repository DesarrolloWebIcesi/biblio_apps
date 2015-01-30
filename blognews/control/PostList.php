<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function postList($npost){
    include_once '../lib/dbservices.php';
    include_once '../model/Post.php';
    $postlist=array();
    $conecto=dbservices::conectar();
    if($conecto==true){        
        $sql = 'select wp_1079_posts.post_content contenido , wp_1079_posts.post_title titulo , wp_1079_posts.post_date fecha '
        . ' from wp_1079_posts , wp_1079_term_relationships '
        . ' where wp_1079_term_relationships.term_taxonomy_id = 3 and '
        . ' wp_1079_term_relationships.object_id = wp_1079_posts.id '
        . ' order by wp_1079_posts.post_date desc LIMIT 0, '.$npost.' ;';

        //echo  $sql.'<br/>';
        $resultados=dbservices::ejecutar_consulta($sql);

        while ($row = mysql_fetch_array($resultados)){
            //echo 'resultado<br/>';
            $post=new Post();
            $post->setTitle($row['titulo']);
            $post->setContent($row['contenido']);
            $post->setPost_date($row['fecha']);

            $postlist[]=$post;
        }
    }
    dbservices::desconectar();
    //echo count($postlist);
    return $postlist;
}
?>

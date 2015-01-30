SELECT post_title, post_content, post_date
FROM wp_24_post
WHERE post_status = 'publish'
AND post_type = 'post'
AND post_category = ':cod_biblio'
ORDER BY `post_date` ASC; 

SELECT post_title, post_content, post_date
FROM wp_24_post
WHERE post_status = 'publish' AND post_type = 'post' AND post_category = 0
ORDER BY post_date DESC
LIMIT 0,2;
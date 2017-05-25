<?php
// Custom Posts
// add_action('init', 'pdftvtpl2LetterPage_package_posts');

//shortcode hooks


add_action('init', 'kivauk_scripts');
add_action('init', 'kivauk_postypes');



//Metabox
add_action('add_meta_boxes', 'kiva_box');
add_action('save_post', 'kiva_onsave');



//filter and hook to remove posttype on permalink
add_filter( 'post_type_link', 'kivauk_remove_posttype_slug', 10, 3 );
add_action( 'pre_get_posts', 'kivauk_fix_page_to_show' );

?>

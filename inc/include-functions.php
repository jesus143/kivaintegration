<?php

//$FomBuilder = new Umbrella\FOM\FomBuilder();


//http://api.kivaws.org/v1/loans/2930.json
add_filter( 'the_content', 'kivauk_the_content_filter', 10 );

function kivauk_the_content_filter($content){


	if(get_post_type($post->ID)=="kivauk"){

 		$loadtemplateRs = kivauk_base_dir.'/templates/template-kiva.php';
 		include($loadtemplateRs);

	}

	return $content;
}


function kivauk_scripts() {

	wp_enqueue_media();
	wp_enqueue_style('pdftvtpl2-jqueryui-style', kivauk_plugin_url."/assets/jquery-ui/jquery-ui.css");

}


function kivauk_remove_posttype_slug( $post_link, $post, $leavename ) {

    if ( 'kivauk' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}


function kivauk_fix_page_to_show( $query ) {

    // Only noop the main query
    if ( ! $query->is_main_query() )
        return;

    // Only noop our very specific rewrite rule match
    if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'page', 'kivauk' ) );
    }
}

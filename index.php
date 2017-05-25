<?php
/**
 * Plugin Name: Kiva Integration
 * Plugin URI: http://Umbrellamindtech.epizy.com/
 * Description: Wordpress Kiva Inteagtrion
 * Version: 1.0
 * Author: Floyd Patulot
 * Author URI: http://Umbrellamindtech.epizy.com/
 * License: All rights reserved??
 */

/**
 * This is the main dir path of the plugin
 */


 if ( ! defined( 'kivauk_base_file' ) )
    define( 'kivauk_base_file', __FILE__ );
if ( ! defined( 'kivauk_base_dir' ) )
    define( 'kivauk_base_dir', dirname( kivauk_base_file ) );

define('kivauk_path', plugin_dir_path( __FILE__ )); // Example:
define('kivauk_unique','kivauk_');
define('kivauk_plugin_url',plugins_url('',__FILE__));


/**
 * Here you can setup settings of the plugin
 */

if(!function_exists('wp_get_current_user')) {include(ABSPATH . "wp-includes/pluggable.php");}


function kivauk_on_activate() {

		// //page to be created when install
		// global $wpdb;

		// $page_slugs =  array('Mission Objectives','Mission Progress','Monthly Mission Objectives','Mission Ping');

		// foreach($page_slugs as $page_title){

		//  $page_slug = str_replace(" ", "-", strtolower($page_title));

		//   $template[] = $page_slug;

		//  $page = get_page_by_path( $page_slug , OBJECT );

		//  if ( !isset($page) ):

		// 	if($page_slug=="mission-objectives"){

		// 		$content = '[payouts_rate_card]';

		// 	}else{

		// 		$content = "";
		// 	}

		// 	$kivauk_page = array(
		// 	'post_title'    => $page_title,
		// 	'post_type'     => 'page',
		// 	'post_content'  => $content,
		// 	'post_status'   => 'publish',
		// 	'post_author'   => get_current_user_id(),
		// 	);

		// 	$kivauk_page_id = wp_insert_post( $kivauk_page );

		// endif;


		// }

		// update_option('kivauk_templates',serialize($template));

}

function kivauk_on_deactivate(){


}



register_activation_hook( __FILE__, 'kivauk_on_activate' );
register_uninstall_hook(__FILE__, 'kivauk_on_deactivate');



/**
 * start hook function
 */

require_once ("inc.functions.php");




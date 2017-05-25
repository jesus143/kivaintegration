<?php
// Pdf Template
function kivauk_postypes()
{

  $labels = array(
    'name' => _x('Kiva Page', 'post type general name'),
    'singular_name' => _x('Kiva Page', 'post type singular name'),
    'add_new' => _x('Add New', 'Kiva Page'),
    'add_new_item' => __('Add New Kiva Page'),
    'edit_item' => __('Edit Kiva Page'),
    'new_item' => __('New Kiva Page'),
    'all_items' => __('All Kiva Page'),
    'view_item' => __('View Kiva Page'),
    'search_items' => __('Search Kiva Page'),
    'not_found' =>  __('No Pdf Template found'),
    'not_found_in_trash' => __('No Kiva Page found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Kiva'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 4,
	'menu_icon' => 'dashicons-list-view',
    //'rewrite' => array('slug' => '/'),
    'supports' => array('title','author','thumbnail','revisions','page-attributes')
  );

  register_post_type('kivauk',$args);

  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Category' ),
    'all_items' => __( 'All Category' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Category' ),
  );

  register_taxonomy('kiva_category', 'kivauk', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'kiva_category' ),
  ));

  flush_rewrite_rules();


}


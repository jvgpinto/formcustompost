<?php

//Create the custom type to be used in the form
function create_custompost_ctp(){
    $labels = array(
        'name' => __('Custom Post', 'Post Type General Name', 'custompost'),
        'singular_name' => __('Custom Post', 'Post Type Singular Name', 'custompost'),
        'menu_name' => __('Custom Post', 'custompost'),
        'menu_admin_bar' => __('Custom Post', 'custompost'),
        'archives' => __('Custom Post Archives', 'custompost'),
        'attributes' => __('Custom Post Attributes', 'custompost'),
        'parent_item_colon' => __('Parent Custom Post', 'custompost'),
        'all_items' => __('All Custom Posts', 'custompost'),
        'add_new_item' => __('Add New Custom Post', 'custompost'),
        'add_new' => __('Add New', 'custompost'),
        'new_item' => __('New Custom Post', 'custompost'),
        'edit_item' => __('Edit Custom Post', 'custompost'),
        'update_item' => __('Update Custom Post', 'custompost'),
        'view_item' => __('View Custom Post', 'custompost'),
        'view_items' => __('View Custom Posts', 'custompost'),
        'search_item' => __('Search Custom Post', 'custompost'),
        'not_found' => __('Not found', 'custompost'),
        'not_found_in_trash' => __('Not found in trash', 'custompost'),
        'featured_image' => __('Featured Image', 'custompost'),
        'set_featured_image' => __('Set featured Image', 'custompost'),
        'remove_featured_image' => __('Remove featured Image', 'custompost'),
        'use_featured_image' => __('Use as featured Image', 'custompost'),
        'insert_into_item' => __('Insert into Custom Post', 'custompost'),
        'uploaded_to_this_item' => __('Upladed to this Custom Post', 'custompost'),        
        'items_list' => __('Custom Post list', 'custompost'),    
        'items_list_navigation' => __('Custom Post list navigation', 'custompost'),    
        'filter_items_list' => __('Filter Custom Post list', 'custompost'),
    );
    $args = array(
        'label' => __('Custom Post', 'custompost'),
        'description' => __('A custom post type to be created from a form in the website.', 'custompost'),
        'labels' => $labels,
        'menu_icon' => 'dashicons-id' ,
        'supports' => array('title', 'editor', 'thumbnail','revisions','author','custom-fields','page-attributes'),
        'taxonomies' => array('category', 'post_tag'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'delete_with_user' => false,
        'rest_base' => 'custompost',
        'rewrite' => array('slug' => 'custompost')
    );
    register_post_type( 'custompost', $args);
}

//Give wp the capability to rewrite the url permalinks.
function rewrite_custompost_flush(){
    create_custompost_ctp();
    flush_rewrite_rules();
}
register_activation_hook( '__FILE__', 'rewrite_custompost_flush' );

function get_all_custompost()
{
    $args = array(  
        'post_type' => 'custompost',
        'post_status' => 'publish',
        'posts_per_page' => -1, 
        'orderby' => 'title', 
        'order' => 'ASC',
    );

    $loop = new WP_Query( $args ); 
        
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $featured_img = wp_get_attachment_image_src( $post->ID );
        print the_title();
        the_excerpt(); 
    endwhile;

    wp_reset_postdata(); 
}

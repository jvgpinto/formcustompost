<?php

//Create the custom type to be used in the form
function create_custompost_ctp(){
    $customPostTypeName = get_option( 'custompost_CTP_name', 'Custom post' );
    $labels = array(
        'name' => __($customPostTypeName, 'Post Type General Name', 'custompost'),
        'singular_name' => __($customPostTypeName, 'Post Type Singular Name', 'custompost'),
        'menu_name' => __($customPostTypeName, 'custompost'),
        'menu_admin_bar' => __($customPostTypeName, 'custompost'),
        'archives' => __($customPostTypeName.' Archives', 'custompost'),
        'attributes' => __($customPostTypeName.' Attributes', 'custompost'),
        'parent_item_colon' => __('Parent '.$customPostTypeName, 'custompost'),
        'all_items' => __('All '.$customPostTypeName, 'custompost'),
        'add_new_item' => __('Add New '.$customPostTypeName, 'custompost'),
        'add_new' => __('Add New', 'custompost'),
        'new_item' => __('New '.$customPostTypeName, 'custompost'),
        'edit_item' => __('Edit '.$customPostTypeName, 'custompost'),
        'update_item' => __('Update '.$customPostTypeName, 'custompost'),
        'view_item' => __('View '.$customPostTypeName, 'custompost'),
        'view_items' => __('View '.$customPostTypeName.'s', 'custompost'),
        'search_item' => __('Search '.$customPostTypeName, 'custompost'),
        'not_found' => __('Not found', 'custompost'),
        'not_found_in_trash' => __('Not found in trash', 'custompost'),
        'featured_image' => __('Featured Image', 'custompost'),
        'set_featured_image' => __('Set featured Image', 'custompost'),
        'remove_featured_image' => __('Remove featured Image', 'custompost'),
        'use_featured_image' => __('Use as featured Image', 'custompost'),
        'insert_into_item' => __('Insert into '.$customPostTypeName, 'custompost'),
        'uploaded_to_this_item' => __('Upladed to this '.$customPostTypeName, 'custompost'),        
        'items_list' => __($customPostTypeName.' list', 'custompost'),    
        'items_list_navigation' => __($customPostTypeName.' list navigation', 'custompost'),    
        'filter_items_list' => __('Filter '.$customPostTypeName.' list', 'custompost'),
    );
    $args = array(
        'label' => __($customPostTypeName, 'custompost'),
        'description' => __('A custom post type: '.$customPostTypeName.' to be created from a form in the website.', 'custompost'),
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
        'rewrite' => array('slug' => create_slug_from_name($customPostTypeName))
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
    $html = '<ul class="custompost-ul">';   
    $li = ''; 
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $featured_img = wp_get_attachment_image_src( $post->ID );
        $permalink = esc_attr(esc_url( get_permalink($post)));
        $li .= '<li class="custompost-li">';
        $li .=  the_title('<a href="'.$permalink.'">', '</a>', false);
        $li .= '</li>';
        // the_excerpt(); 
    endwhile;
    $html .= '</ul>';

    wp_reset_postdata(); 
    // console_log('get_all_custompost');
    // console_log($li);
    return '
    <div class="list-all-custompost">
        <ul class="custompost-ul">
            '.$li.'
        </ul>
    </div>';
}
function create_slug_from_name($name)
{
    $name = remove_accents($name);
    $name = strtolower($name);
    $name = str_replace(" ","-",$name);
    return $name;
}
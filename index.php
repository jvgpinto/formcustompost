<?php

/**
 * Plugin Name:       Form custom post
 * Plugin URI:        https://github.com/jvgpinto/formcustompost
 * Description:       Create a custom post type with a form that can create a post from the front-end and send an email to a designed approver.
 * Version:           1.0.1
 * Requires at least: 4.1.5
 * Requires PHP:      5.4.45
 * Author:            Joao Pinto
 * Author URI:        https://github.com/jvgpinto
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/jvgpinto/formcustompost
 */

//Security
if(!defined('ABSPATH')){
    echo 'Nothing to do when you call me directly';
    die;
}
 //Support functions
include('functions/tools.php');

 //Custom fields
 include('functions/customFields.php');
add_action( 'admin_init', 'Create_Custom_Fields');

 //Custom type
include('functions/CTP.php');
add_action( 'init', 'create_custompost_ctp', 0 );
add_shortcode( 'allformcustompost', 'get_all_custompost' );

include('functions/form.php');
add_shortcode( 'formcustompost', 'custompost_frontend_post' );

include('functions/settings.php');
add_action('updated_option', 'settings_updated', 10, 3);

//Custom filters for title and content.
include('functions/filters.php');
add_filter( 'wpcf7_form_elements', 'do_shortcode' );
add_filter( 'the_title', 'filter_title_custompost',10,2);
add_filter( 'the_content', 'filter_content_custompost');
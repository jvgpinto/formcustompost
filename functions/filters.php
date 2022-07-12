<?php
/* Add the content in settings to all posts */
function filter_content_custompost ( $content ) {
    console_log($content);
    console_log('Option(custompost_field_content)=> '.get_option('custompost_field_content'));
    console_log('ShortCode=> '.get_option('custompost_field_shortcode_end'));

    if ( get_post_type( get_the_ID() ) == 'custompost' ) {
            if ( shortcode_exists( get_option('custompost_field_shortcode_end')) ) {
                $content .= do_shortcode('['.get_option('custompost_field_shortcode_end').']');
            }
            return '<p>'.get_option('custompost_field_content').'</p> '.$content;
    }   
    return $content;
}

function filter_title_custompost ( $title ) {    
    if ( get_post_type( get_the_ID() ) == 'custompost' ) {
            return esc_html__(get_option('custompost_field_title')).' '.$title;
    }   
    return $title;
}
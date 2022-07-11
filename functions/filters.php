<?php
/* Add the content in settings to all posts */
function filter_content_custompost ( $content ) {
    console_log($content);
    console_log(get_option('custompost_field_content'));
    if ( get_post_type( get_the_ID() ) == 'custompost' ) {
            return get_option('custompost_field_content').' '.$content;
    }   
    return $content;
}

function filter_title_custompost ( $title ) {
    console_log($title);
    
    if ( get_post_type( get_the_ID() ) == 'custompost' ) {
            return esc_html__(get_option('custompost_field_title')).' '.$title;
    }   
    return $title;
}


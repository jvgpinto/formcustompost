<?php
/* Add the content in settings to all posts */
function filter_content_custompost ( $content ) {
    if (is_single() AND get_post_type( get_the_ID() ) == 'custompost' ) {
            $shortCode = get_option('custompost_field_shortcode_end');
            if ( !empty($shortCode) ) {
                $content .= do_shortcode('['.get_option('custompost_field_shortcode_end').']');
            }
            return '<p class="custompost">'.get_option('custompost_field_content').'</p> '.$content;
    }   
    return $content;
}

function filter_title_custompost ( $title, $id = null ) {    

    if ( ! is_admin() && ! is_null( $id ) ) {
        $post = get_post( $id );
        if ( $post instanceof WP_Post && ( $post->post_type == 'custompost') ) {
            $new_title = esc_html__(get_option('custompost_field_title','')).' '.$title;
            $requesterName = esc_html__(get_post_meta( $post->ID, 'requesterName_custompost', true);)
            if( ! empty( $new_title ) ) {
                $new_title = $new_title."<input type='hidden' id='custompost-title' value='".$title."'/>";
                if( ! empty( $requesterName ) ) {
                    $new_title = $new_title."<input type='hidden' id='custompost-requester-name' value='".$requesterName."'/>";
                }
                return $new_title;
            }
        }
    }
    return $title;
}
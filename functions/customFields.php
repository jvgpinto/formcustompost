<?php

 //add style 
 include('styles.php');
 add_action( 'admin_init', 'add_admin_css');
function Create_Custom_Fields(){
    add_meta_box( 
        'custompost_cf',                    //ID
        'Custom post details',              //Title of the fields
        'show_custom_fields_custompost',    //Custom fields function
        'custompost', 
        'normal',
        'low' 
    );
}
function show_custom_fields_custompost(){
    global $post;
    $name_custompost = get_post_meta( $post->ID, 'name_custompost', true);
    $requesterName_custompost = get_post_meta( $post->ID, 'requesterName_custompost', true);
    $requesterPhone_custompost = get_post_meta( $post->ID, 'requesterPhone_custompost', true);
    $requesterEmail_custompost = get_post_meta( $post->ID, 'requesterEmail_custompost', true);
    
    ?>
        <div class="custompost_admin_container">
            <label for="name_custompost" > Name <br>
                <input class="custompost" id="name_custompost" name="name_custompost" value="<?php echo esc_attr($name_custompost) ?>">
            </label>
            <label for="requesterName_custompost"> Requester name <br>
                <input class="custompost" id="requesterName_custompost" name="requesterName_custompost" value="<?php echo esc_attr($requesterName_custompost) ?>">
            </label>
            <label for="requesterPhone_custompost"> Requester phone <br>
                <input class="custompost" id="requesterPhone_custompost" name="requesterPhone_custompost" value="<?php echo esc_attr($requesterPhone_custompost) ?>">
            </label>
            <label for="requesterEmail_custompost"> Requester e-mail <br>
                <input class="custompost" id="requesterEmail_custompost" name="requesterEmail_custompost" value="<?php echo esc_attr($requesterEmail_custompost) ?>">
            </label>
        </div>
    <?php

}

function save_custom_fields_custompost($post_id, $post, $update){
    if($_POST){
        global $post_data;
        $sanitized_name_custompost = wp_filter_post_kses( $_POST['name_custompost'] );
        $sanitized_requesterName_custompost = wp_filter_post_kses( $_POST['requesterName_custompost'] );
        $sanitized_requesterPhone_custompost = wp_filter_post_kses( $_POST['requesterPhone_custompost'] );
        $sanitized_requesterEmail_custompost = wp_filter_post_kses( $_POST['requesterEmail_custompost'] );

        update_post_meta( $post_id, 'name_custompost' , $sanitized_name_custompost );
        update_post_meta( $post_id, 'requesterName_custompost' , $sanitized_requesterName_custompost );
        update_post_meta( $post_id, 'requesterPhone_custompost' , $sanitized_requesterPhone_custompost );
        update_post_meta( $post_id, 'requesterEmail_custompost' , $sanitized_requesterEmail_custompost );
    }
}

add_action( 'save_post', 'save_custom_fields_custompost', 1, 3);
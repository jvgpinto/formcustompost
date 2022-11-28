<?php

 //add style 
 include('styles.php');
 add_action( 'admin_init', 'add_admin_css');
function Create_Custom_Fields(){
    $customPostTypeName = get_option( 'custompost_CTP_name', 'Custom post' );
    add_meta_box( 
        'custompost_cf',                    //ID
        $customPostTypeName.' details',     //Title of the fields
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
    $requesterAddress_custompost = get_post_meta( $post->ID, 'requesterAddress_custompost', true);
    $requesterCity_custompost = get_post_meta( $post->ID, 'requesterCity_custompost', true);
    $requesterPostalCode_custompost = get_post_meta( $post->ID, 'requesterPostalCode_custompost', true);
    $requesterProvinceCountry_custompost = get_post_meta( $post->ID, 'requesterProvinceCountry_custompost', true);
    
    ?>
        <div class="custompost_admin_container">
            <label for="name_custompost" > <?php __("Name") ?> <br>
                <input class="custompost" id="name_custompost" name="name_custompost" value="<?php echo esc_attr($name_custompost) ?>">
            </label>
            <label for="requesterName_custompost"> <?php __("Requester name") ?> <br>
                <input class="custompost" id="requesterName_custompost" name="requesterName_custompost" value="<?php echo esc_attr($requesterName_custompost) ?>">
            </label>
            <label for="requesterPhone_custompost"> <?php __("Requester phone") ?> <br>
                <input class="custompost" id="requesterPhone_custompost" name="requesterPhone_custompost" value="<?php echo esc_attr($requesterPhone_custompost) ?>">
            </label>
            <label for="requesterEmail_custompost"> <?php __("Requester e-mail") ?> <br>
                <input class="custompost" id="requesterEmail_custompost" name="requesterEmail_custompost" value="<?php echo esc_attr($requesterEmail_custompost) ?>">
            </label>
            <label for="requesterAddress_custompost"> <?php __("Requester address") ?> <br>
                <input class="custompost" id="requesterAddress_custompost" name="requesterAddress_custompost" value="<?php echo esc_attr($requesterAddress_custompost) ?>">
            </label>
            <label for="requesterCity_custompost"> <?php __("Requester city") ?> <br>
                <input class="custompost" id="requesterCity_custompost" name="requesterCity_custompost" value="<?php echo esc_attr($requesterCity_custompost) ?>">
            </label>
            <label for="requesterPostalCode_custompost"> <?php __("Requester postal code") ?> <br>
                <input class="custompost" id="requesterPostalCode_custompost" name="requesterPostalCode_custompost" value="<?php echo esc_attr($requesterPostalCode_custompost) ?>">
            </label>
            <label for="requesterProvinceCountry_custompost"> <?php __("Requester province, country") ?> <br>
                <input class="custompost" id="requesterProvinceCountry_custompost" name="requesterProvinceCountry_custompost" value="<?php echo esc_attr($requesterProvinceCountry_custompost) ?>">
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
        $sanitized_requesterAddress_custompost = wp_filter_post_kses( $_POST['requesterAddress_custompost'] );
        $sanitized_requesterCity_custompost = wp_filter_post_kses( $_POST['requesterCity_custompost'] );
        $sanitized_requesterPostalCode_custompost = wp_filter_post_kses( $_POST['requesterPostalCode_custompost'] );
        $sanitized_requesterProvinceCountry_custompost = wp_filter_post_kses( $_POST['requesterProvinceCountry_custompost'] );

        update_post_meta( $post_id, 'name_custompost' , $sanitized_name_custompost );
        update_post_meta( $post_id, 'requesterName_custompost' , $sanitized_requesterName_custompost );
        update_post_meta( $post_id, 'requesterPhone_custompost' , $sanitized_requesterPhone_custompost );
        update_post_meta( $post_id, 'requesterEmail_custompost' , $sanitized_requesterEmail_custompost );
        update_post_meta( $post_id, 'requesterAddress_custompost' , $sanitized_requesterAddress_custompost );
        update_post_meta( $post_id, 'requesterCity_custompost' , $sanitized_requesterCity_custompost );
        update_post_meta( $post_id, 'requesterPostalCode_custompost' , $sanitized_requesterPostalCode_custompost );
        update_post_meta( $post_id, 'requesterProvinceCountry_custompost' , $sanitized_requesterProvinceCountry_custompost );
    }
}

add_action( 'save_post', 'save_custom_fields_custompost', 1, 3);
<?php

/**
 * custom option and settings
 */
function custompost_settings_init() {
    // Register a new setting for "custompost" page.
    register_setting( 'custompost', 'custompost_CTP_name' );
    register_setting( 'custompost', 'custompost_field_title' );
    register_setting( 'custompost', 'custompost_field_content' );
    register_setting( 'custompost', 'custompost_field_shortcode_end' );
    register_setting( 'custompost', 'custompost_field_approver_email' );
 
    // Register a new section in the "custompost" page.
    add_settings_section(
        'custompost_section_general',
        __( 'Custom post default text', 'custompost' ), 'custompost_section_general_callback',
        'custompost'
    );
 
    // Register a new field in the "custompost_section_general" section, inside the "custompost" page.
    add_settings_field(
        'custompost_CTP_name', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'The name of the content type', 'custompost' ),
        'custompost_field_html_generate',
        'custompost',
        'custompost_section_general',
        array(
            'label_for'         => 'custompost_CTP_name',
            'class'             => 'custompost_row',
            'custompost_custom_data' => '',
            'type'              => 'input',
            'description'       => esc_attr( 'The name will be used on menu' )
        )
    );
    // Register a new field in the "custompost_section_general" section, inside the "custompost" page.
    add_settings_field(
        'custompost_field_title', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Text default title sufix', 'custompost' ),
        'custompost_field_html_generate',
        'custompost',
        'custompost_section_general',
        array(
            'label_for'         => 'custompost_field_title',
            'class'             => 'custompost_row',
            'custompost_custom_data' => '',
            'type'              => 'input',
            'description'       => esc_attr( 'This will be inserted before the title' )
        )
    );
    add_settings_field(
        'custompost_field_content', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Text default for post content', 'custompost' ),
        'custompost_field_html_generate',
        'custompost',
        'custompost_section_general',
        array(
            'label_for'         => 'custompost_field_content',
            'class'             => 'custompost_row',
            'custompost_custom_data' => '',
            'type'              => 'richtext',
            'description'       => esc_attr( 'The content of the custom post will be replaced to this text.' )
        )
    );
    add_settings_field(
        'custompost_field_shortcode_end', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'The shortcode to inclue on the end of the content if we have one.', 'custompost' ),
        'custompost_field_html_generate',
        'custompost',
        'custompost_section_general',
        array(
            'label_for'         => 'custompost_field_shortcode_end',
            'class'             => 'custompost_row',
            'custompost_custom_data' => '',
            'type'              => 'input',
            'description'       => esc_attr( 'The name of the shortcode to inclue on the end of the content if we have one whithout [].' )
        )
    );

    
    // Register a new section in the "custompost" page.
    add_settings_section(
        'custompost_section_email_config',
        __( 'Email notification settings', 'custompost' ), 
        function($args){
            ?>
            <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This section we need email settings', 'custompost' ); ?></p>
            <?php
        },
        'custompost'
    );
    add_settings_field(
        'custompost_field_approver_email', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Approver email', 'custompost' ),
        'custompost_field_html_generate',
        'custompost',
        'custompost_section_email_config',
        array(
            'label_for'         => 'custompost_field_approver_email',
            'class'             => 'custompost_row',
            'custompost_custom_data' => '',
            'type'              => 'input',
            'description'       => esc_attr( 'The email to receive email notifications of created contents that need approval.' )
        )
    );
}
 
/**
 * Register our custompost_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'custompost_settings_init' );
 
function custompost_section_general_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This section we need the general settings', 'custompost' ); ?></p>
    <?php
}
 
function custompost_field_html_generate( $args ) {
    // Get the value of the setting we've registered with register_setting()
    //console_log($args['label_for']);
    $value = get_option( $args['label_for']);
    //console_log($value);
    $all_options = wp_load_alloptions();
    //console_log($all_options);
    switch ($args['type']) {
        case "input":
            ?>
                <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                    <input  
                    id="<?php echo esc_attr( $args['label_for'] ); ?>"
                    name="<?php echo esc_attr( $args['label_for'] ); ?>" 
                    value="<?php echo esc_attr($value); ?>" />
                </label>
                <p class="description">
                    <?php echo $args['description'] ?>
                </p>
            <?php
            break;
        case "textarea":
            ?>
                <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                    <textarea 
                        id="<?php echo esc_attr( $args['label_for'] ); ?>" 
                        name="<?php echo esc_attr( $args['label_for'] ); ?>" 
                        value="<?php echo esc_textarea($value); ?>" rows="5" cols="70">
                        <?php echo trim(esc_textarea($value)); ?>
                    </textarea>
                </label>
                <p class="description">
                    <?php echo $args['description'] ?>
                </p>
            <?php
            break;
       case "richtext":
            ?>
               <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                    <?php
                        $settings = array();
                        wp_editor( $value, $args['label_for'], $settings );
                    ?>

                </label>
                <p class="description">
                    <?php echo $args['description'] ?>
                </p>
            <?php
            break;
        default:
            ?>
                <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                    <input  
                    id="<?php echo esc_attr( $args['label_for'] ); ?>"
                    name="custompost_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                    value="<?php echo esc_attr($value); ?>" />
                </label>
                <p class="description">
                    <?php echo $args['description'] ?>
                </p>
            <?php
        break;
    }
}
 
/**
 * Add the top level menu page.
 */
function custompost_options_page() {
    // add_menu_page(
    //     'Custom post plugin settings',
    //     'Custom post Options',
    //     'manage_options',
    //     'custompost',
    //     'custompost_options_page_html',
    //     '',
    //     5
    // );
    // add_submenu_page( 
    // 'custompost',//$parent_slug:string, 
    // 'Custom post plugin settings',//$page_title:string, 
    // 'Settings',//$menu_title:string, 
    // 'manage_options',//$capability:string, 
    // 'custompost',//$menu_slug:string,
    // 'custompost_options_page_html',// $function:callable, 
    // 10 );
    add_submenu_page(
        'edit.php?post_type=custompost',
        __( 'Custom post plugin settings', 'custompost' ),
        __( 'Settings', 'custompost' ),
        'manage_options',
        'custompost',
        'custompost_options_page_html'
    );
}
 
 
/**
 * Register our custompost_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'custompost_options_page' );
 
 
/**
 * Top level menu callback function
 */
function custompost_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'custompost_messages', 'custompost_message', __( 'Settings Saved', 'custompost' ), 'updated' );
    }
    if(isset($_POST['custompost_field_content'])  ){
        $htmlContent= htmlentities(wpautop($_POST['custompost_field_content']));
        console_log($htmlContent);
        $fff= update_option('custompost_field_content', $htmlContent);
    }
 
    // show error/update messages
    settings_errors( 'custompost_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "custompost"
            settings_fields( 'custompost' );
            // output setting sections and their fields
            // (sections are registered for "custompost", each field is registered to a specific section)
            do_settings_sections( 'custompost' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
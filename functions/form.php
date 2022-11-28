<?php
//add SweetAlert js library and scripts
function wpb_hook_javascript_head() {
    ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript"> 
        document.addEventListener('DOMContentLoaded', function(){ 
            const form = document.getElementById('new_post');
            if(form){
                form.addEventListener('submit', submitForm);
            }
            if(document.getElementsByName("donInMe")[0] && document.getElementById("custompost-title")){
                document.getElementsByName("donInMe")[0].value = document.getElementById("custompost-title").value
            }
        }, false)
            function submitForm(e){
                e.preventDefault();
                var btnSubmit = document.getElementById('custompost-submit');
                btnSubmit.innerHTML = btnSubmit.innerText + '  <i class="fa fa-circle-o-notch fa-spin"></i>';
                btnSubmit.disabled = true;
                document.getElementById("new_post").submit();
                return false;
            };
        </script>
    <?php
}
add_action('wp_head', 'wpb_hook_javascript_head');
if( ! function_exists('custompost_post_if_submitted' ) ):

	function custompost_post_if_submitted() {
        require_once(ABSPATH . 'wp-config.php'); 
        require_once(ABSPATH . 'wp-includes/wp-db.php'); 
        require_once(ABSPATH . 'wp-admin/includes/taxonomy.php'); 
        
        // Stop running function if form wasn't submitted
        if ( empty($_POST) ) {
            return;
        }
        //Add category with the first letter if not exists
        $catName = strtoupper(substr($_POST['name_custompost'],0,1));
        $title = $_POST['name_custompost'];
        $content = '';
        if ( shortcode_exists( 'custompost_field_shortcode_end' ) ) {
            $content .= do_shortcode('['.get_option('custompost_field_shortcode_end').']');
        }
        $id_category_created = wp_create_category($catName);
        // Add the content of the form to $post as an array
        $post = array(
            'post_title'    => $title,
            'post_content'  => '',//$content,
            'post_category' => array($id_category_created), 
            'tags_input'    => $_POST['nom_defunt'],
            'post_status'   => 'draft',
            'post_type' 	=> 'custompost', // Could be: 'page' or your CPT
            'post_author'   => $_POST['name_custompost'],
            //custom fields
            'meta_input' => array(
                'name_custompost' => $_POST['name_custompost'],
                'requesterName_custompost' => $_POST['requesterName_custompost'],
                'requesterPhone_custompost' => $_POST['requesterPhone_custompost'],
                'requesterEmail_custompost' => $_POST['requesterEmail_custompost'],
                'requesterAddress_custompost' => $_POST['requesterAddress_custompost'],
                'requesterCity_custompost' => $_POST['requesterCity_custompost'],
                'requesterPostalCode_custompost' => $_POST['requesterPostalCode_custompost'],
                'requesterProvinceCountry_custompost' => $_POST['requesterProvinceCountry_custompost']
            )
        );
        $post_id = wp_insert_post($post);
        send_mail($post,$post_id);
        
        // For Featured Image
        if( !function_exists('wp_generate_attachment_metadata')){
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
        if($_FILES) {
            foreach( $_FILES as $file => $array ) {
                if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){
                    return "upload error : " . $_FILES[$file]['error'];
                }
                $attach_id = media_handle_upload( $file, $post_id );
            }
        }
        if($attach_id > 0) {
            update_post_meta( $post_id,'_thumbnail_id', $attach_id );
        }
        if(get_option( "custompost_field_create_translations", false)){
            create_languages_version($post_id, $post, $attach_id);
        }
        if($post_id > 0){
            $confirmMessage = get_option( "custompost_field_form_submited_message", "Form submited." );
            show_confirm_message($confirmMessage);
        }
	}
endif;

//Create the form front-end
//if( ! function_exists('custompost_frontend_post' ) ):
if( ! function_exists('custompost_frontend_post' ) ):    
    function custompost_frontend_post() {
        custompost_post_if_submitted(); 
        return '
		<div class="custompost_form_container">
			<form id="new_post" name="new_post" method="post" enctype="multipart/form-data">
				<p>
					<label for="name_custompost">'.esc_html__('Name of the deceased').'</label>
					<br />
					<input type="text" id="name_custompost" value="" tabindex="0" size="50" name="name_custompost" required/>
				</p>
				<p>
					<label for="requesterName_custompost">'.esc_html__('Name of requester').'</label>
					<br />
					<input type="text" value="" tabindex="0" size="50" name="requesterName_custompost" id="requesterName_custompost" required/>
				</p>
				<p>
					<label for="requesterEmail_custompost">'.esc_html__("Requester's email").'</label>
					<br />
					<input type="email" value="" tabindex="0" size="16" name="requesterEmail_custompost" id="requesterEmail_custompost" aria-required="true" required/>
				</p>
                <p>
					<label for="requesterAddress_custompost">'.esc_html__("Requester's address").'</label>
					<br />
					<input type="text" value="" tabindex="0" size="50" name="requesterAddress_custompost" id="requesterAddress_custompost" aria-required="true" required/>
				</p>
                <p>
					<label for="requesterCity_custompost">'.esc_html__("Requester's city").'</label>
					<br />
					<input type="text" value="" tabindex="0" size="50" name="requesterCity_custompost" id="requesterCity_custompost" aria-required="true" required/>
				</p>
                <p>
					<label for="requesterPostalCode_custompost">'.esc_html__("Requester's postal code").'</label>
					<br />
					<input type="text" value="" tabindex="0" size="16" name="requesterPostalCode_custompost" id="requesterPostalCode_custompost" aria-required="true" required/>
				</p>
                <p>
					<label for="requesterProvinceCountry_custompost">'.esc_html__("Province, state, country of requester").'</label>
					<br />
					<input type="text" value="" tabindex="0" size="16" name="requesterProvinceCountry_custompost" id="requesterProvinceCountry_custompost" aria-required="true" required/>
				</p>
				<p>
					<label for="requesterPhone_custompost">'.esc_html__("Requester's phone").'</label>
					<br />
					<input type="tel" value="" tabindex="0" size="16" name="requesterPhone_custompost" id="requesterPhone_custompost" aria-required="true" required/>
				</p>
				<p>
					<label for="post_image">
						'.esc_html__("Upload a picture").'
					</label>
					<br />
					<input type="file" name="post_image" id="post_image" aria-required="true" required>
				</p>

				<p>
                    <button type="submit" tabindex="0" id="custompost-submit" name="custompost-submit">
                        '.__('Submit').'
                    </button
                </p>
			
			</form>
		</div>';   
    }
endif;

function send_smtp_email( $phpmailer ) {
   
    $phpmailer->isSMTP();
    $phpmailer->Host       = get_option( 'custompost_field_phpmailer_host' ,'');
    $phpmailer->Port       = get_option( 'custompost_field_phpmailer_port' , 587);
    $phpmailer->SMTPSecure = get_option( 'custompost_field_phpmailer_secure' ,'tls');
    $phpmailer->SMTPAuth   = get_option( 'custompost_field_phpmailer_smtpauth ' ,true);
    $phpmailer->Username   = get_option( 'custompost_field_phpmailer_username' ,'');
    $phpmailer->Password   = get_option( 'custompost_field_phpmailer_psw' ,'');
    $phpmailer->From       = get_option( 'custompost_field_phpmailer_from' ,'');
    $phpmailer->FromName   = get_option( 'custompost_field_phpmailer_fromName' ,'');
}

function set_my_mail_content_type() {
    return "text/html";
}

function send_mail($post,$post_id) {
    $adminEmail = get_option( 'custompost_field_approver_email' );
    $subject = "Nouveau contenu soumis en attente d'approbation.";
    $urlPost = get_edit_post_link($post_id);
    $message = '<h1>Voici les informations: </h1><br>';
    $postCustomFields = $post['meta_input'];
    $message .="<br><b>Nom du défunt</b>:       {$postCustomFields['name_custompost']}";
    $message .="<br><b>Nom du demandeur</b>: {$postCustomFields['requesterName_custompost']}";
    $message .="<br><b>Téléphone</b>:        {$postCustomFields['requesterPhone_custompost']}";
    $message .="<br><b>Courriel</b>:         {$postCustomFields['requesterEmail_custompost']}";
    
    $message .="<br><b>Adresse du demandeur</b>:         {$postCustomFields['requesterEmail_custompost']}";
    $message .="<br><b>Ville du demandeur</b>:         {$postCustomFields['requesterEmail_custompost']}";
    $message .="<br><b>Courriel</b>:         {$postCustomFields['requesterEmail_custompost']}";
    $message .="<br><b>Courriel</b>:         {$postCustomFields['requesterEmail_custompost']}";
    $message .= "<br><br><div><!--[if mso]> <v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='{$urlPost}' style='height:38px;v-text-anchor:middle;width:200px;' arcsize='11%' strokecolor='#28501e' fillcolor='#92b441'> <w:anchorlock/> <center style='color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;'>Voir le contenu</center></v:roundrect><![endif]--><a href='{$urlPost}' style='background-color:#92b441;border:1px solid #28501e;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:38px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;'>Voir le contenu</a></div>";
    $to = $adminEmail;
    $subject = $subject;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    //Verify in settings if use custom smtp.
    if(get_option('custompost_field_phpmailer_iscustom', 0 ) != 1 ){
        $mailSent = wp_mail( $to, $subject, $message,$headers );
        console_log("Email sent by default wp_mail");
    }else{
        console_log('Custom wp_mail sent');
        add_filter( 'wp_mail_content_type','set_my_mail_content_type' );
        add_action( 'phpmailer_init', 'send_smtp_email' );

        $mailSent = wp_mail( $to, $subject, $message,$headers );

        remove_filter( 'wp_mail_content_type','set_my_mail_content_type' );
        remove_action( 'phpmailer_init', 'send_smtp_email' );
    }

}

function create_languages_version($postIdOrigin, $postOrigin, $attach_id){
    //https://localhost/fhmc/wp-admin/post-new.php?post_type=custompost&from_post=2877&new_lang=en
        

    if (function_exists('pll_set_post_language') 
        && function_exists('pll_save_post_translations')) {
        $args = array(
            'display_names_as' => 'slug',
            'raw' => 1
        );
        $default_lang = pll_default_language();
        $all_languages = pll_the_languages( $args );
        pll_set_post_language($postIdOrigin, $default_lang);

        
        $posts = array();
        foreach ($all_languages as $language => $value) {
            if(!$value["current_lang"]){
                $posts[$value["slug"]] = "";
            }
        }

        // create post on the other languages.
        foreach ($posts as $language => $value) {
            $posts[$language] = wp_insert_post($postOrigin);
        }

        // set post language.
        foreach ($posts as $language => $value) {
            pll_set_post_language($value, $language);
            update_post_meta( $value,'_thumbnail_id', $attach_id );
        } 
        $posts[$default_lang] = $postIdOrigin;      
        pll_save_post_translations($posts);
    }
}

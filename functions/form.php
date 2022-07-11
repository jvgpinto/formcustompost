<?php

if( ! function_exists('custompost_post_if_submitted' ) ):

	function custompost_post_if_submitted() {
        // Stop running function if form wasn't submitted
        if ( empty($_POST) ) {
            return;
        }

        //Add category with the first letter if not exists
        $catName = strtoupper(substr($_POST['name_custompost'],0,1));
        $title = $_POST['name_custompost'];
        $content = esc_html__(get_option('custompost_field_content'));
        if ( shortcode_exists( 'custompost_field_shortcode_end' ) ) {
            $content .= do_shortcode('['.get_option('custompost_field_shortcode_end').']');
        }
        $id_category_created = wp_create_category($catName);
        // Add the content of the form to $post as an array
        $post = array(
            'post_title'    => $title,
            'post_content'  => $content,
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
                'requesterEmail_custompost' => $_POST['requesterEmail_custompost']
            )
        );
        $post_id = wp_insert_post($post);
        
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
        if($post_id > 0){
            
            echo "<script>alert('Votre page a été sumis et sera annalisé sous peu. Merci.')</script>";
            email_create($post);
        }
	}
endif;

//Creation of email html 
function email_create($post){
    $adminEmail = get_option( 'custompost_field_approver_email' );
    $subject = esc_html__("Contenu en attends de l'approbation");;
    $urlPost = get_edit_post_link($post_id);
    $body = esc_html__('Voici les informations soumis: <br>'.json_encode( $post ).'<br><br> <a href="'.$urlPost.'" target="_blank">Approuver</a>');
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $emailSent = wp_mail( $adminEmail, $subject, $body, $headers, array('') );
    console_log('Email sent=> '.$emailSent.' Email admin=> '.$adminEmail.' subject=> '.$subject.' message=> '.$body);
}

//Create the form front-end
if( ! function_exists('custompost_frontend_post' ) ):
    function custompost_frontend_post() {
        custompost_post_if_submitted(); 
        return '
		<div class="custompost_form_container">
			<form id="new_post" name="new_post" method="post"  enctype="multipart/form-data">
				<p>
					<label for="name_custompost">'.esc_html__('Nom du défunt').'</label>
					<br />
					<input type="text" id="name_custompost" value="" tabindex="0" size="50" name="name_custompost" />
				</p>
				<p>
					<label for="requesterName_custompost">'.esc_html__('Nom du demandeur').'</label>
					<br />
					<input type="text" value="" tabindex="0" name="requesterName_custompost" id="requesterName_custompost" />
				</p>
				<p>
					<label for="post_image">
						'.esc_html__("Télécharger une photo").'
					</label>
					<br />
					<input type="file" name="post_image" id="post_image" aria-required="true">
				</p>
				<p>
					<label for="requesterPhone_custompost">'.esc_html__('Téléphone du demandeur').'</label>
					<br />
					<input type="tel" value="" tabindex="0" size="16" name="requesterPhone_custompost" id="requesterPhone_custompost" aria-required="true"/>
				</p>
				<p>
					<label for="requesterEmail_custompost">'.esc_html__('Courriel du demandeur').'</label>
					<br />
					<input type="email" value="" tabindex="0" size="16" name="requesterEmail_custompost" id="requesterEmail_custompost" aria-required="true"/>
				</p>

				<p><input type="submit" value="Soumettre" tabindex="0" id="submit" name="submit" /></p>
			
			</form>
		</div>';    
    }
endif;

<?php
if( ! function_exists('console_log' ) ):
	function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
endif;
if(! function_exists('show_confirm_message') ):
	function show_confirm_message($message){
		$confirmPopUp = "";
		echo '<script>';
		echo 'Swal.fire({ 
			icon: "success",
			title: "'.__('Merci').'",
			text: "'.__($message).'"
		  })';
		echo '</script>';
	}
endif;
function short_code_example() { 
  
	// TODO remove 
	return '<h3>Example shortcode plugin custom post</h3>'; 
	  
	}
	// Register shortcode
	add_shortcode('my_short_code', 'short_code_example'); 
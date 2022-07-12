<?php
if( ! function_exists('console_log' ) ):
	function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
endif;

function short_code_example() { 
  
	// TODO remove 
	return '<h3>Example shortcode plugin custom post</h3>'; 
	  
	}
	// Register shortcode
	add_shortcode('my_short_code', 'short_code_example'); 
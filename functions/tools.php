<?php
if( ! function_exists('console_log' ) ):
	function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
endif;
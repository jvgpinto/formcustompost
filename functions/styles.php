<?php

if( !function_exists('add_admin_css' ) ):
    function add_admin_css(){
        echo '
            <style>
            input.custompost{
            }
            div.custompost_admin_container{
                display: flex;
                flex-direction: column;
            }
            div.custompost_form_container{
                display: flex;
                font-family: inherit;
                font-size: inherit;
            }
            </style>
        ';
    }
endif;
 
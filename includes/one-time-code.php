<?php
	/**
	 * Save your PHP script to the *theme*includes/onetimecode folder; 
	 * Script should be self-executing (Immediately Invoked)
	 */
	call_user_func( function (){
		$dir = plugin_dir_path( __FILE__ )."onetimecode";
		if ($handle = opendir( $dir )) {

		    while (false !== ($entry = readdir($handle))) {
		
		        if ($entry != "." && $entry != "..") {
					require_once( $dir."/".$entry );
					unlink( $dir."/".$entry );

		        }
		    }
		
		    closedir($handle);
		}

	});
?>
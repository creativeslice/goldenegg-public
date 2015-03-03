<?php
/**
 * Plugin Name: File Redirects
 * Description: Serves content from wp-content/uploads from /assets/ (Or an alternate upload location - uses wp_upload_dir() to determine)
 * Version: 0.2
 * Author: Chris Marslender
 * Author URI: http://chrismarslender.com
 * Contributer: Jake Snyder (added $_SERVER['REQUEST_URI'])
 * Contributer: Trip Grass (added WPEngine Instructions)
 * Author URI: http://creativeslice.com
 *
 * Uses a lot of code from wp-includes/ms-files.php (the old multisite file redirection stuff)
 *
 * Can be useful on servers where the other assets-rewrites don't work and on nginx servers. 
 * It doesn't currently rewrite plugins directories, but can be updated if needed.
 */
 
 /**
 * On Apache add to htaccess (and restart server): 
 
	<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase /subfolder
	RewriteRule ^index\.php$ - [L]
	RewriteRule ^assets/css/(.*) wp-content/themes/creativeslice-2015/assets/css/$1 [QSA,L]
	RewriteRule ^assets/js/(.*) wp-content/themes/creativeslice-2015/assets/js/$1 [QSA,L]
	RewriteRule ^assets/img/(.*) wp-content/themes/creativeslice-2015/assets/img/$1 [QSA,L]
	RewriteRule ^plugins/(.*) wp-content/plugins/$1 [QSA,L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule . /index.php [L]
	</IfModule>

   On nginx have wpengine add to nginx.config file (before rules):
   
	location ~ ^/assets/(img|js|css|fonts)/(.*)$ {
		try_files $uri $uri/ /wp-content/themes/goldenegg/assets/$1/$2;
	}
	location ~ ^/plugins/(.*)$ {
		try_files $uri $uri/ /wp-content/plugins/$1;
	}
	
 *	
 */


/**
 * Rewrite the urls
 *
 * Filter the request and serve the files directly when appropriate
 */
add_filter( 'request', function( $query_vars ) {

	// Check if pagename starts with "assets/'
	if (! empty($query_vars['error']) && isset( $_SERVER['REQUEST_URI'] ) && false !== stripos( $_SERVER['REQUEST_URI'], '/assets/' ) ) {

		$file = trailingslashit( get_template_directory() ) . $_SERVER['REQUEST_URI'];

		if ( file_exists( $file ) ) {

			$mime = wp_check_filetype( $file );
			if( false === $mime[ 'type' ] && function_exists( 'mime_content_type' ) )
				$mime[ 'type' ] = mime_content_type( $file );

			if( $mime[ 'type' ] )
				$mimetype = $mime[ 'type' ];
			else
				$mimetype = 'image/' . substr( $file, strrpos( $file, '.' ) + 1 );

			header( 'Content-Type: ' . $mimetype ); // always send this

			if ( false === strpos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS' ) )
				header( 'Content-Length: ' . filesize( $file ) );

			$last_modified = gmdate( 'D, d M Y H:i:s', filemtime( $file ) );
			$etag = '"' . md5( $last_modified ) . '"';
			header( "Last-Modified: $last_modified GMT" );
			header( 'ETag: ' . $etag );
			header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 100000000 ) . ' GMT' );

			// Support for Conditional GET - use stripslashes to avoid formatting.php dependency
			$client_etag = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? stripslashes( $_SERVER['HTTP_IF_NONE_MATCH'] ) : false;

			if( ! isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) )
				$_SERVER['HTTP_IF_MODIFIED_SINCE'] = false;

			$client_last_modified = trim( $_SERVER['HTTP_IF_MODIFIED_SINCE'] );
			// If string is empty, return 0. If not, attempt to parse into a timestamp
			$client_modified_timestamp = $client_last_modified ? strtotime( $client_last_modified ) : 0;

			// Make a timestamp for our most recent modification...
			$modified_timestamp = strtotime($last_modified);

			if ( ( $client_last_modified && $client_etag )
				? ( ( $client_modified_timestamp >= $modified_timestamp) && ( $client_etag == $etag ) )
				: ( ( $client_modified_timestamp >= $modified_timestamp) || ( $client_etag == $etag ) )
			) {
				status_header( 304 );
				exit;
			}

			// If we made it this far, just serve the file
			readfile( $file );
			exit();
		}
	}

	return $query_vars;
});

/**
 * Update functions to output relative URLs
 */
add_action( 'after_setup_theme', 'egg_assets_rewrites' );
function egg_assets_rewrites()
{
	// Define helper constants
	$get_theme_name = explode('/themes/', get_template_directory());

	define('RELATIVE_PLUGIN_PATH',  str_replace(home_url() . '/', '', plugins_url()));
	define('RELATIVE_CONTENT_PATH', str_replace(home_url() . '/', '', content_url()));
	define('THEME_NAME',            next($get_theme_name));
	define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);

	function egg_clean_urls( $content )
	{
		if ( strpos($content, RELATIVE_PLUGIN_PATH) > 0 )
			return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);
		else
			$replace = str_replace('/' . THEME_PATH, '', $content);
			return $replace;
	}

	if (! is_multisite() && !is_child_theme() )
	{
		if (! is_admin() )
		{
			$tags = array(
				#'plugins_url',
				'bloginfo',
				'stylesheet_directory_uri',
				'template_directory_uri',
				'script_loader_src',
				'style_loader_src'
			);

			foreach ( $tags as $tag )
			{
				add_filter($tag, 'egg_clean_urls');
			}
		}
	}
}
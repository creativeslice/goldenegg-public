<?php // CLEANUP & REFINE PLUGINS


/**
 * PLUGIN: Rank Math SEO
 *
 * @link https://rankmath.com/kb/filters-hooks-api-developer/ 
 */

// Filter to turn off auto-update notification emails.
add_filter( 'rank_math/auto_update_send_email', '__return_false' );

// Filter to remove the plugin credit notice added to the source.
add_filter( 'rank_math/frontend/remove_credit_notice', '__return_true' );

// Filter to remove `rank-math-link` class from the frontend content links
add_filter( 'rank_math/link/remove_class', '__return_true' );

// Filter to remove sitemap credit.
add_filter( 'rank_math/sitemap/remove_credit', '__return_true');



/**
 * PLUGIN: Simple History
 *
 * @link https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php
 */
 
/* Load only the loggers that are specified in the $do_log_us array */
add_filter('simple_history/logger/load_logger', function ($load_logger, $logger_basename) {
    $load_logger = false;

    $do_log_us = [
        'SimpleUserLogger',
        'SimpleMediaLogger',
        'SimplePostLogger',
        'SimpleCategoriesLogger',
        'SimplePluginLogger',
        'SimpleLogger',
    ];

    if (in_array($logger_basename, $do_log_us)) {
        $load_logger = true;
    }

    return $load_logger;
},10,2);


/* Limit Log Messages */
add_filter('simple_history/simple_logger/log_message_key', function ($doLog, $loggerSlug, $messageKey, $SimpleLoggerLogLevelsLevel, $context) {
	
    // Don't log login attempts to non existing users
    if ('SimpleUserLogger' == $loggerSlug && 'user_unknown_login_failed' == $messageKey) {
        $doLog = false;
    }
    
	// Don't log failed logins to existing users
	if ( 'SimpleUserLogger' == $loggerSlug && 'user_login_failed' == $messageKey ) {
		$doLog = false;
	}
	
	// Don't log doing_it_wrong messages
	if ($messageKey === 'doing_it_wrong') {
        $doLog = false;
    }
    
    return $doLog;
}, 10, 5);

/* Remove the "Clear log"-button, so a user cannot clear the log */
add_filter('simple_history/user_can_clear_log', function ( $user_can_clear_log ) {
	$user_can_clear_log = false;
	return $user_can_clear_log;
});

/* Change capability required to view main simple history page */
add_filter('simple_history/view_history_capability', function ($capability) {
    $capability = 'manage_options'; // edit_pages
    return $capability;
});
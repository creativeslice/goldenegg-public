<?php
	/**
	 * Activate/Deactivate specified plugins in different environment.
	 *
	 * NOTE: you will need to customize the ge_get_environment check  at the start of the function
	 */

	if (!function_exists('ge_get_environment')) :
		/**
		 * @return string
		 */
		function ge_get_environment()
		{
			/** determine environment for forcing activate/deactivate plugins for WPEngine at this time
			 * the only clean way to do that is via DB_USER since WP_ENVIRONMENT_TYPE is always production as of
			 * 2/19/22
			 */
			if (defined('DB_USER')) {
				switch (DB_USER) {
					case 'goldeneggstag':
						$environment = 'staging';
						break;
					case 'goldeneggprod':
						$environment = 'production';
						break;
					case 'goldeneggdev':
					default:
						/** if your local environment uses anything else for defining DB_USER it will
						 * fall back to being develop like
						 */
						$environment = 'develop';
						break;
				}
			}
			return $environment;
		}
	endif;

	if (!function_exists('ge_plugins_manage')) :
		function ge_plugins_manage()
		{
			$environment = ge_get_environment();

			/**
			 * determine the environment and select array of plugins to force activate/deactivate
			 */
			$environment = 'local';
			/** @var  array $deactivate_plugins full paths to plugins to deactivate
			 *  you can start by adding plugins you NEVER want activated
			 *  $deactivate_plugins = array('lazy-blocks/lazy-blocks.php','advanced-custom-fields-pro-master/acf.php');
			 */
			$deactivate_plugins = array();

			/** @var  array $activate_plugins full paths to plugins to activate
			 * you can start by adding plugins you ALWAYS want activated
			 * $activate_plugins = array('lazy-blocks/lazy-blocks.php','advanced-custom-fields-pro-master/acf.php');
			 */
			$activate_plugins = array(
				'lazy-blocks/lazy-blocks.php',
				'advanced-custom-fields-pro-master/acf.php',
			);

			// $current = get_option('active_plugins', array());

			/** add the plugins to force activate/deactivate for each environment
			 * you can use array_merge, array_push, [] or what ever your preferred method for
			 * adding to an EXISTING array is for example
			 * $deactivate_plugins = array_merge($deactivate_plugins,
			 *                                   array('two-factor/two-factor.php'));
			 * $activate_plugins = array_merge($deactivate_plugins,
			 *                                 array(
			 *                                    'a-plugin/a-plugin.php',
			 *                                    'another-plugin/another-plugin.php')
			 *                      );
			 */
			switch ($environment) {
				case 'staging':
					/* $deactivate_plugins = array_merge($deactivate_plugins,
						 array('two-factor/two-factor.php')
					 );

					 $activate_plugins = array_merge($deactivate_plugins,
						 array('a-plugin/a-plugin.php', 'another-plugin/another-plugin.php')
					 );*/
					break;
				case 'production':
					/* $deactivate_plugins = array_merge($deactivate_plugins,
						array('two-factor/two-factor.php')
					);

					$activate_plugins = array_merge($deactivate_plugins,
						array('a-plugin/a-plugin.php', 'another-plugin/another-plugin.php')
					);*/
					break;
				case 'local':
				case 'develop':
				default:
					$deactivate_plugins = array_merge($deactivate_plugins, ['two-factor/two-factor.php']);
					break;
			}
			if (!empty($deactivate_plugins) || !empty($activate_plugins)) {
				require_once(ABSPATH.'wp-admin/includes/plugin.php');
				if (!empty($deactivate_plugins)) {
					deactivate_plugins($deactivate_plugins);
				}
				if (!empty($activate_plugins)) {
					activate_plugins($activate_plugins);
				}
			}
			// $after = get_option('active_plugins', array());
		}
	endif;
	add_action('after_setup_theme', 'ge_plugins_manage');

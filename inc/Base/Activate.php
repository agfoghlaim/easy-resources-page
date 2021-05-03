<?php
/**
 * On plugin activation.
 *
 * @package marie-wp-plugin-starter
 * @version 1.0.0
 */

namespace MariePluginStarter\Base;

/**
 * Activate plugin class.
 */
class Activate {

		/**
		 * On activate.
		 */
	public static function activate() {

		flush_rewrite_rules();
	}
}

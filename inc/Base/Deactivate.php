<?php
/**
 * On plugin deactivation.
 *
 * @package marie-wp-plugin-starter
 * @version 1.0.0
 */

namespace MariePluginStarter\Base;

/**
 * Deactivate plugin class.
 */
class Deactivate {

		/**
		 * On deactivate.
		 */
	public static function deactivate() {

		flush_rewrite_rules();
	}
}

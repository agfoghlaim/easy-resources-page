<?php
/**
 * On plugin deactivation.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\Base;

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

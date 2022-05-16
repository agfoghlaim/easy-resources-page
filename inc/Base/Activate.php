<?php
/**
 * On plugin activation.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\Base;

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

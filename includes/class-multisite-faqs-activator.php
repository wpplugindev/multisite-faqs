<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/wpplugins-tech/multisite-faqs
 * @since      1.0.0
 *
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/includes
 * @author     WPplugins.Tech <info@wpplugins.tech>
 */
class Multisite_FAQS_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		/* default the global faqs site to the main blog */
		add_site_option( 'msfaq_blog_id', 1 );

	}

}

<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/wpplugins-tech/multisite-faqs
 * @since      1.0.0
 *
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/includes
 */

class Multisite_FAQS {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Multisite_FAQS_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'multisite-faqs';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Multisite_FAQS_Loader. Orchestrates the hooks of the plugin.
	 * - Multisite_FAQS_i18n. Defines internationalization functionality.
	 * - Multisite_FAQS_Admin. Defines all hooks for the admin area.
	 * - Multisite_FAQS_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multisite-faqs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multisite-faqs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-multisite-faqs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-multisite-faqs-public.php';


		$this->loader = new Multisite_FAQS_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Multisite_FAQS_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Multisite_FAQS_i18n();
		$plugin_i18n->set_domain( 'multisite-faqs' );
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Multisite_FAQS_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_faqs_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_faqs_group_taxonomy' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_faqs_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'initialize_faqs_options' );
		
		$this->loader->add_filter( 'plugin_action_links_' . MS_FAQS_PLUGIN_BASENAME, $plugin_admin, 'faqs_action_links' );
		
		/* add multi-site admin hooks */
		if (is_multisite() && get_site_option( 'msfaq_blog_id' ) == get_current_blog_id()) {
			/* add global_faq meta_box to faq edit page. */
			$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_global_faq_meta_box' );
			/* Save post meta on the 'save_post' hook. */
			$this->loader->add_action( 'save_post', $plugin_admin, 'save_global_faq_data', 10, 2 );
		}
		/* add multi-site network settings hooks */
		if (is_multisite() ) {
			/* add network settings section. */
			$this->loader->add_action( 'wpmu_options', $plugin_admin, 'add_faq_network_settings');
			/* save network settings. */
			$this->loader->add_action( 'update_wpmu_options', $plugin_admin, 'save_network_settings' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Multisite_FAQS_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'register_faqs_shortcodes' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'faqs_custom_styles' );

		if ( class_exists('Vc_Manager') ) {
			$this->loader->add_action( 'vc_before_init', $plugin_public, 'integrate_shortcode_with_vc' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Multisite_FAQS_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * To log any thing for debugging purposes
	 *
	 * @since   1.0.0
	 *
	 * @param   mixed   $message    message to be logged
	 */
    public static function log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }

}

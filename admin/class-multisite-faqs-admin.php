<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/wpplugindev/multisite-faqs
 * @since      1.0.0
 *
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/admin
 * @author     WPplugindev.Net <info@wpplugindev.net>
 */
class Multisite_FAQS_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * FAQs options
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $options    Contains the plugin options
	 */
	public $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = get_option( 'multisite_faqs_options' );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );
		// plugin custom css file
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multisite-faqs-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multisite-faqs-admin.js', array( 'jquery' , 'wp-color-picker' ), $this->version, false );
	}


	/**
	 * Register FAQs custom post type
	 *
	 * @since     1.0.0
	 */
	public function register_faqs_post_type() {

		$labels = array(
			'name'                => _x( 'FAQs', 'Post Type General Name', 'multisite-faqs' ),
			'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'multisite-faqs' ),
			'menu_name'           => __( 'FAQs', 'multisite-faqs' ),
			'name_admin_bar'      => __( 'FAQs', 'multisite-faqs' ),
			'parent_item_colon'   => __( 'Parent FAQ:', 'multisite-faqs' ),
			'all_items'           => __( 'FAQs', 'multisite-faqs' ),
			'add_new_item'        => __( 'Add New FAQ', 'multisite-faqs' ),
			'add_new'             => __( 'Add New', 'multisite-faqs' ),
			'new_item'            => __( 'New FAQ', 'multisite-faqs' ),
			'edit_item'           => __( 'Edit FAQ', 'multisite-faqs' ),
			'update_item'         => __( 'Update FAQ', 'multisite-faqs' ),
			'view_item'           => __( 'View FAQ', 'multisite-faqs' ),
			'search_items'        => __( 'Search FAQ', 'multisite-faqs' ),
			'not_found'           => __( 'Not found', 'multisite-faqs' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'multisite-faqs' ),
		);

		$args = array(
			'label'               => __( 'faq', 'multisite-faqs' ),
			'description'         => __( 'Frequently Asked Questions', 'multisite-faqs' ),
			'labels'              => apply_filters( 'ms_faq_labels', $labels),
			'supports'            => apply_filters( 'ms_faq_supports', array( 'title', 'editor' ) ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-format-chat',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
		);

		register_post_type( 'faq', apply_filters( 'ms_register_faq_arguments', $args) );

	}

	/**
	 * Register FAQ Group custom taxonomy
	 *
	 * @since     1.0.0
	 */
	public function register_faqs_group_taxonomy() {

		$labels = array(
			'name'                       => _x( 'FAQ Groups', 'Taxonomy General Name', 'multisite-faqs' ),
			'singular_name'              => _x( 'FAQ Group', 'Taxonomy Singular Name', 'multisite-faqs' ),
			'menu_name'                  => __( 'Groups', 'multisite-faqs' ),
			'all_items'                  => __( 'All FAQ Groups', 'multisite-faqs' ),
			'parent_item'                => __( 'Parent FAQ Group', 'multisite-faqs' ),
			'parent_item_colon'          => __( 'Parent FAQ Group:', 'multisite-faqs' ),
			'new_item_name'              => __( 'New FAQ Group Name', 'multisite-faqs' ),
			'add_new_item'               => __( 'Add New FAQ Group', 'multisite-faqs' ),
			'edit_item'                  => __( 'Edit FAQ Group', 'multisite-faqs' ),
			'update_item'                => __( 'Update FAQ Group', 'multisite-faqs' ),
			'view_item'                  => __( 'View FAQ Group', 'multisite-faqs' ),
			'separate_items_with_commas' => __( 'Separate FAQ Groups with commas', 'multisite-faqs' ),
			'add_or_remove_items'        => __( 'Add or remove FAQ Groups', 'multisite-faqs' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'multisite-faqs' ),
			'popular_items'              => __( 'Popular FAQ Groups', 'multisite-faqs' ),
			'search_items'               => __( 'Search FAQ Groups', 'multisite-faqs' ),
			'not_found'                  => __( 'Not Found', 'multisite-faqs' ),
		);

	    $args = array(
		    'labels'            => apply_filters( 'ms_faq_group_labels', $labels ),
		    'hierarchical'      => true,
		    'public'            => false,
		    'rewrite'           => false,
		    'show_ui'           => true,
		    'show_in_menu' 		=> 'edit.php?post_type=faq',
		    'show_admin_column' => true,
		    'show_in_nav_menus' => false,
		    'show_tagcloud'     => false,
	    );

		register_taxonomy( 'faq-group', array( 'faq' ), apply_filters( 'ms_register_faq_group_arguments', $args ) );

	}

	/**
	 * Add custom metabox to faq edit screen - only appears on the main faq site
	 *
	 * @since     1.0.0
	 */
	public function add_global_faq_meta_box()
	{
		add_meta_box(
			'multisite_faq',                                // Unique ID
			 __('Multisite FAQ', 'multisite-faqs'),         // Box title
			 array( $this, 'render_global_faq_metabox' ),   // Content callback, must be of type callable
			'faq',                                          // Post type
			'side',                                         // Context
			'default'                                       // Priority
		);
	}
	
	/**
	 * Renders custom metabox
	 *
	 * @since     1.0.0
	 */
	public function render_global_faq_metabox($post)
	{ 
		?>
			<?php wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );  ?>
			<?php $global_faq = get_post_meta( $post->ID, 'global_faq', true ) ?>
			<input id="global_faq" type="checkbox" name="global_faq" <?php if($global_faq != '') echo 'checked' ?>>
			<label for="global_faq"><?php _e( 'Show on all sites', 'multisite-faqs' ); ?></label>
		<?php
	}

	/**
	 * Saves data from the global_faq metabox
	 *
	 * @since     1.0.0
	 */
	public function save_global_faq_data($post_id,$post)
	{
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
		$nonce_action = 'custom_nonce_action';

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		$post_type = get_post_type_object( $post->post_type );

		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;
		// sanitize and validate _POST variables
		$global_faq = sanitize_key($_POST['global_faq']);
		// check for valid values
		if ($global_faq != 'on' && $global_faq != null) { 
			$global_faq = null;
		}

		delete_post_meta( $post_id, 'global_faq' );
		add_post_meta( $post_id, 'global_faq', $global_faq, true );

	}


	
	/**
	 * Add plugin settings page
	 */
	public function add_faqs_options_page(){

		/**
		 * Add FAQs settings page
		 */
	    add_submenu_page(
		    'edit.php?post_type=faq',
		    __( 'Multisite FAQs Settings', 'multisite-faqs' ),
		    __( 'Settings', 'multisite-faqs' ),
		    'manage_options',
		    'multisite_faqs',
		    array( $this, 'display_faqs_options_page')
	    );

	}

	/**
	 * Returns an array of sites for the network
	 */
	public  function get_sites( $args = array() ) {

		if ( version_compare( get_bloginfo('version'), '4.6', '>=' ) ) {
			$defaults = array( 'number' => 5000 );
			$args = wp_parse_args( $args, $defaults );
			$args = apply_filters( 'msfaq_get_sites_args', $args );
			$sites = get_sites( $args );
			foreach( $sites as $key => $site ) {
				$sites[$key] = (array) $site;
			}
			return $sites;
		} else {
			$defaults = array( 'limit' => 5000 );
			$args = apply_filters( 'msfaq_get_sites_args', $args );
			$args = wp_parse_args( $args, $defaults );
			return wp_get_sites( $args );
		}

	}

	/**
	 * Adds a section for the MSFAQ plugin to the network settings page
	 */
	public function add_faq_network_settings() {

		?>
	
		<h2><?php _e( 'Multisite Faq Settings', 'multisite-faqs'); ?></h2>
		<table id="msfaq" class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Global FAQs Site', 'multisite-faqs' ); ?></th>
				<td>
					<?php
					$network_blogs = $this->get_sites();
					$selected_blog_id = get_site_option( 'msfaq_blog_id' ); // defaults to main blog

					echo '<select name="msfaq_blog_id">';
					foreach( $network_blogs as $site ) {  
						$isselected = "";
						$this_blog_id = $site['blog_id'];
					
							if ( $this_blog_id == $selected_blog_id ) {
								$isselected = "selected";
								$domain = $site['domain'];
							}
					
						echo '<option value="' . $site['blog_id'] . '"' . $isselected . '>' . $site['domain'] . '</option>';
					}
					echo '</select>';
					?>
				</td>
			</tr>
		</table>

		<?php

	}

	/**
	 * Saves the network settings for the MSFAQ plugin
	 */
	public function save_network_settings() {

		if ( isset($_POST['msfaq_blog_id']) ) {

			// sanitize and validate _POST variables
			$msfaq_blog_id = sanitize_key($_POST['msfaq_blog_id']);
			$msfaq_blog_id = intval($msfaq_blog_id);
			if ($msfaq_blog_id == 0 ) { // value should be an int > 0
				$msfaq_blog_id = 1;     // if not a valid value set to the main blog id
			}

			update_site_option( 'msfaq_blog_id', $msfaq_blog_id );
		}

	}


	/**
	 * Display FAQs settings page
	 */
	public function display_faqs_options_page() {

		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Multisite FAQS Settings', 'multisite-faqs' ); ?></h2>

			<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
			<?php settings_errors(); ?>

			<!-- Create the form that will be used to render our options -->
			<form method="post" action="options.php">
				<?php settings_fields( 'multisite_faqs_options' ); ?>
				<?php do_settings_sections( 'multisite_faqs_options' ); ?>
				<?php submit_button(); ?>
			</form>

		</div><!-- /.wrap -->
		<?php
	}

	/**
	 * Initialize FAQs settings page
	 */
	public function initialize_faqs_options(){

		// create plugin options if not exist
		if( false == $this->options ) {
			add_option( 'multisite_faqs_options' );
		}

		/**
		 * Section
		 */
		add_settings_section(
			'faqs_toggles_style',                                                  // ID used to identify this section and with which to register options
			__( 'FAQs Toggle Styles', 'multisite-faqs'),                           // Title to be displayed on the administration page
			array( $this, 'faqs_toggles_style_description'),                       // Callback used to render the description of the section
			'multisite_faqs_options'                                               // Page on which to add this section of options
		);

		add_settings_section(
			'faqs_common_style',
			__( 'FAQs Common Styles', 'multisite-faqs'),
			array( $this, 'faqs_common_style_description'),
			'multisite_faqs_options'
		);

		/**
		 * Fields
		 */
		add_settings_field(
			'faqs_toggle_colors',
			__( 'FAQs toggle colors', 'multisite-faqs' ),
			array( $this, 'faqs_select_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'faqs_toggle_colors',
				'default' => 'default',
				'description' => __( 'Choose custom colors to apply colors provided in options below.', 'multisite-faqs' ),
				'options' => array(
					'default' => __( 'Default Colors', 'multisite-faqs' ),
					'custom' => __( 'Custom Colors', 'multisite-faqs' ),
				)
			)
		);
		add_settings_field(
			'toggle_question_color',
			__( 'Question text color', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_question_color',
				'default' => '#333333',
			)
		);
		add_settings_field(
			'toggle_question_hover_color',
			__( 'Question text color on mouse over', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_question_hover_color',
				'default' => '#333333',
			)
		);
		add_settings_field(
			'toggle_question_bg_color',
			__( 'Question background color', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_question_bg_color',
				'default' => '#fafafa',
			)
		);
		add_settings_field(
			'toggle_question_hover_bg_color',
			__( 'Question background color on mouse over', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_question_hover_bg_color',
				'default' => '#eaeaea',
			)
		);
		add_settings_field(
			'toggle_answer_color',
			__( 'Answer text color', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_answer_color',
				'default' => '#333333',
			)
		);
		add_settings_field(
			'toggle_answer_bg_color',
			__( 'Answer background color', 'multisite-faqs' ),
			array( $this, 'faqs_color_option_field' ),
			'multisite_faqs_options',
			'faqs_toggles_style',
			array(
				'id' => 'toggle_answer_bg_color',
				'default' => '#ffffff',
			)
		);
		add_settings_field(
			'toggle_border_color',                               // ID used to identify the field throughout the theme
			__( 'Toggle Border color', 'multisite-faqs' ),       // The label to the left of the option interface element
			array( $this, 'faqs_color_option_field' ),           // The name of the function responsible for rendering the option interface
			'multisite_faqs_options',                            // The page on which this option will be displayed
			'faqs_toggles_style',                                // The name of the section to which this field belongs
			array(                                               // The array of arguments to pass to the callback. In this case, just a description.
				'id' => 'toggle_border_color',
				'default' => '#dddddd',
			)
		);
		add_settings_field(
			'faqs_custom_css',
			__( 'Custom CSS', 'multisite-faqs' ),
			array( $this, 'faqs_textarea_option_field' ),
			'multisite_faqs_options',
			'faqs_common_style',
			array(
				'id' => 'faqs_custom_css',
			)
		);

		/**
		 * Register Settings
		 */
		register_setting( 'multisite_faqs_options', 'multisite_faqs_options' );
	}

	/**
	 * FAQs toggle styles section description
	 */
	public function faqs_toggles_style_description() {
		echo '<p>'. __( 'These settings only applies to FAQs with toggle style. As FAQs with list style use colors inherited from currently active theme.', 'multisite-faqs' ) . '</p>';
	}

	/**
	 * FAQs common styles section description
	 */
	public function faqs_common_style_description() {
		echo '<p>'.__( '', 'multisite-faqs' ).'</p>';
	}

	/**
	 * Re-usable color options field for FAQs settings
	 *
	 * @param $args array   field arguments
	 */
	public function faqs_color_option_field( $args ) {
		$field_id = $args['id'];
		if( $field_id ) {
			$val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : $args['default'];
			$default_color = $args['default'];
			echo '<input type="text" name="multisite_faqs_options['.$field_id.']" value="' . $val . '" class="color-picker" data-default-color="' . $default_color . '">';
		} else {
			_e( 'Field id is missing!', 'multisite-faqs' );
		}
	}

	/**
	 * Re-usable textarea options field for FAQs settings
	 *
	 * @param $args array   field arguments
	 */
	public function faqs_textarea_option_field( $args ) {
		$field_id = $args['id'];
		if( $field_id ) {
			$val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : '';
			echo '<textarea cols="60" rows="8" name="multisite_faqs_options[' . $field_id . ']" class="faqs-custom-css">' . $val . '</textarea>';
		} else {
			_e( 'Field id is missing!', 'multisite-faqs' );
		}
	}

	/**
	 * Re-usable select options field for FAQs settings
	 *
	 * @param $args array   field arguments
	 */
	public function faqs_select_option_field( $args ) {
		$field_id = $args['id'];
		if( $field_id ) {
			$existing_value = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : '';
			?>
			<select name="<?php echo 'multisite_faqs_options[' . $field_id . ']'; ?>" class="faqs-select">
				<?php foreach( $args['options'] as $key => $value ) { ?>
					<option value="<?php echo $key; ?>" <?php selected( $existing_value, $key ); ?>><?php echo $value; ?></option>
				<?php } ?>
			</select>
			<br/>
			<label><?php echo $args['description']; ?></label>
			<?php
		} else {
			_e( 'Field id is missing!', 'multisite-faqs' );
		}
	}

	/**
	 * Add plugin action links
	 *
	 * @param $links
	 * @return array
	 */
	public function faqs_action_links( $links ) {
		$links[] = '<a href="'. get_admin_url( null, 'edit.php?post_type=faq&page=multisite_faqs' ) .'">' . __( 'Settings', 'multisite-faqs' ) . '</a>';
		return $links;
	}

}

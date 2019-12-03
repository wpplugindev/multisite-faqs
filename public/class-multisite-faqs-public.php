<?php
/**
 *
 * @link       https://github.com/wpplugins-tech/multisite-faqs
 * @since      1.0.0
 *
 * @package    Multisite_FAQS
 * @subpackage Multisite_FAQS/public
 *
 * The public-facing functionality of the plugin.
 *
 * @author     WPplugins.Tech <info@wpplugins.tech>
 */
class Multisite_FAQS_Public {

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
	 * FAQs global_faq_site
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      int    $global_faq_site    the blog_id of the main blog for faqs - as selected in network settings
	 */
	public $global_faq_site; // only used if multisite

	/**
	 * Is shortcode being used or not
	 *
	 * @since    1.0.0
	 * @var bool
	 */
	private $shortcode_being_used;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		if (is_multisite())
			$this->global_faq_site = get_site_option( 'msfaq_blog_id' );
		$this->shortcode_being_used = false;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( $this->is_shortcode_being_used() ) {
			wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/css/font-awesome.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multisite-faqs-public.css', array(), $this->version, 'all' );

			// if rtl is enabled
			if ( is_rtl() ) {
				wp_enqueue_style( $this->plugin_name . '-rtl', plugin_dir_url( __FILE__ ) . 'css/multisite-faqs-public-rtl.css', array(
					$this->plugin_name,
					'font-awesome'
				), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( $this->is_shortcode_being_used() ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multisite-faqs-public.js', array( 'jquery' ), $this->version, false );
		}

	}

	/**
	 * @return bool
	 */
	private function is_shortcode_being_used() {

		if ( $this->shortcode_being_used ) {
			return true;
		} else {
			global $post;
			if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'faqs' ) ) {
				$this->shortcode_being_used = true;
				return true;
			}
			return false;
		}
	}

	/**
	 * Generate custom css for FAQs based on settings
	 */
	public function faqs_custom_styles () {

		$faqs_options = get_option( 'multisite_faqs_options' );

		if ( $faqs_options && $faqs_options['faqs_toggle_colors'] == 'custom' ) {

			$faqs_custom_css = array();

			// Toggle question color
			if ( ! empty ( $faqs_options['toggle_question_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-title',
					'property'	=>	'color',
					'value'		=> 	$faqs_options['toggle_question_color']
				);
			}

			// Toggle question color on mouse over
			if ( ! empty ( $faqs_options['toggle_question_hover_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-title:hover',
					'property'	=>	'color',
					'value'		=> 	$faqs_options['toggle_question_hover_color']
				);
			}

			// Toggle question background
			if ( ! empty ( $faqs_options['toggle_question_bg_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-title',
					'property'	=>	'background-color',
					'value'		=> 	$faqs_options['toggle_question_bg_color']
				);
			}

			// Toggle question background on mouse over
			if ( ! empty ( $faqs_options['toggle_question_hover_bg_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-title:hover',
					'property'	=>	'background-color',
					'value'		=> 	$faqs_options['toggle_question_hover_bg_color']
				);
			}

			// Toggle answer color
			if ( ! empty ( $faqs_options['toggle_answer_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-content',
					'property'	=>	'color',
					'value'		=> 	$faqs_options['toggle_answer_color']
				);
			}

			// Toggle answer background color
			if ( ! empty ( $faqs_options['toggle_answer_bg_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-content',
					'property'	=>	'background-color',
					'value'		=> 	$faqs_options['toggle_answer_bg_color']
				);
			}

			// Toggle border color
			if ( ! empty ( $faqs_options['toggle_border_color'] ) ) {
				$faqs_custom_css[] = array(
					'elements'	=>	'.ms-faq-toggle .ms-toggle-content, .ms-faq-toggle .ms-toggle-title',
					'property'	=>	'border-color',
					'value'		=> 	$faqs_options['toggle_border_color']
				);
			}

			// Generate css
			if( 0 < count ( $faqs_custom_css ) ) {
				echo "<style type='text/css' id='faqs-custom-colors'>\n";
				foreach ( $faqs_custom_css as $css_unit ) {
					if ( ! empty ( $css_unit[ 'value' ] ) ) {
						echo $css_unit['elements']."{\n";
						echo $css_unit['property'].":".$css_unit['value'].";\n";
						echo "}\n";
					}
				}
				echo '</style>';
			}

		}

		// FAQs custom CSS
		if ( $faqs_options ) {
			$faqs_custom_css = stripslashes( $faqs_options['faqs_custom_css'] );
			if( ! empty ( $faqs_custom_css ) ) {
				echo "\n<style type='text/css' id='faqs-custom-css'>\n";
				echo $faqs_custom_css . "\n";
				echo "</style>";
			}
		}

	}

	/**
	 * Register FAQs shortcodes
	 *
	 * @since   1.0.0
	 */
	public function register_faqs_shortcodes() {
		add_shortcode( 'faqs', array( $this, 'display_faqs_list') );
	}

	/**
	 * Display faqs in a list
	 *
	 * @since   1.0.0
	 * @param   array   $attributes     Array of attributes
	 * @return  string  generated html by shortcode
	 */
	public function display_faqs_list( $attributes ) {

		extract( shortcode_atts( array(
			'style' => 'list',
			'grouped' => 'no',
			'filter' => null,
		), $attributes ) );

		$filter_array = array();

		// faq groups filter
		if ( ! empty ( $filter ) ) {
			$filter_array = explode( ',', $filter );
		}

		ob_start();

		if ( $style == 'toggle' ) {
			if ( $grouped == 'yes' ) {
				$this->toggles_grouped_faqs( $filter_array );
			} else {
				$this->toggles_for_all_faqs( $filter_array );
			}
		} else {
			if ( $grouped == 'yes' ) {
				$this->list_grouped_faqs( $filter_array );
			} else {
				$this->list_all_faqs( $filter_array );
			}
		}

		return ob_get_clean();
	}


	/**
	 * Display FAQs in list style
	 *
	 * @since   1.0.0
	 * @param   Array   $filter_array   Array of faq groups slugs
	 */
	private function list_all_faqs( $filter_array ) {

		$faqs_query_args = array(
			'post_type' => 'faq',
			'posts_per_page' => -1,
		);

		if ( ! empty ( $filter_array ) ) {
			$faqs_query_args['tax_query'] = array(
				array (
					'taxonomy' => 'faq-group',
					'field'    => 'slug',
					'terms'    => $filter_array,
				),
			);
		}
	  
		$faqs_query = new WP_Query( $faqs_query_args );

		// get main blog faqs only if we are not in blog main blog
		if ( get_current_blog_ID() != $this->global_faq_site && is_multisite() ) {

			// set up args to get global faqs
			$faqs_query_args['meta_key'] = 'global_faq';
			$faqs_query_args['meta_value'] = 'on';

			switch_to_blog($this->global_faq_site);

				$faqs_query_global = new WP_Query( $faqs_query_args );

			restore_current_blog();

			// merge the posts if there are global posts in the main blog
			if ( $faqs_query_global->have_posts() ) {
				$faqs_query_final = $this->merge_posts($faqs_query, $faqs_query_global); 
			}
			else {
				$faqs_query_final = $faqs_query;
			}
			
		}
		else {
			// use the original query if in main blog
			$faqs_query_final = $faqs_query;
		}
	   
		// FAQs index
		if ( $faqs_query_final->have_posts() ) :
			echo '<div id="ms-faqs-index" class="ms-faqs-index">';
				echo '<ol class="ms-faqs-index-list">';
					while ( $faqs_query_final->have_posts() ) :
						$faqs_query_final->the_post();
						?><li><a href="#ms-faq-<?php the_ID(); ?>"><?php  the_title(); ?></a></li><?php  
					endwhile;
				echo '</ol>';
			echo '</div>';
		endif;

		// rewind faqs loop
		$faqs_query_final->rewind_posts();

		// FAQs Contents
		if ( $faqs_query_final->have_posts() ) :
			while ( $faqs_query_final->have_posts() ) :
				$faqs_query_final->the_post();
				?>
				<div id="ms-faq-<?php the_ID(); ?>" class="ms-faq-content">
					<h4><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
					<?php  the_content(); // following p tag to fix display bug ?></p>
					<a class="ms-faq-top" href="#ms-faqs-index"><i class="fa fa-angle-up"></i>
					<?php _e( 'Back to Index', 'multisite-faqs'); ?></a>
				</div>
			<?php
			endwhile;
		endif;

		// All the custom loops ends here so reset the query
		wp_reset_query();

	}


	/**
	 * Merge faq groups removing duplicates
	 *
	 * @since   1.0.0
	 * @param   Array   $faq_groups           Array of faq groups
	 * @param   Array   $faq_groups_global    Array of faq groups
	 * @return  Array   $faq_groups_all       Array of merged faq groups
	 * 
	 */
	private function merge_faq_groups( $faq_groups, $faq_groups_global ) {

		// add the first group to the array
		$faq_groups_all = $faq_groups;

		// loop over second group to check for duplicates
		foreach ( $faq_groups_global as $faq_group ) {
			$slug_exists = false;
			// check if the slug is already in faq_groups_current
			foreach ( $faq_groups as $group ) {
				if ($group->slug == $faq_group->slug )
					$slug_exists = true;
			}
		   // if slug is not found add this term to the faq_groups_all array
		   if (!$slug_exists) 
				$faq_groups_all[] = $faq_group;
		}

		return $faq_groups_all;
	}



	/**
	 * Is current term slug in the passed in groups /original global/ term slug list
	 *
	 * @since   1.0.0
	 * @param   Array   $faq_groups           Array of faq groups
	 * @param   Array   $this_slug            Group slug
	 * @return  Bool    $slug_exists
	 */
	private function faq_group_in_blog( $faq_groups, $this_slug ) {

		$slug_exists = false;
		foreach ($faq_groups as $faq_group) {
			if ($faq_group->slug == $this_slug)
				$slug_exists = true;
		}
		return $slug_exists;
	}


	/**
	 * Merge the posts from two separate wp_queries
	 *
	 * @since   1.0.0
	 * @param   Array   $faqs_queries_current           WP_Query object
	 * @param   Array   $faqs_queries_global            WP_Query object
	 * @return  Array   $faqs_queries                   WP_Query object
	 * 
	 */
	private function merge_posts( $faqs_queries_current, $faqs_queries_global ) {

		$faqs_queries = new WP_Query();
		$faqs_queries->posts = array(); // arrays won't merge otherwise
	
		// merge both queries - note global faqs appear first
		if ($faqs_queries_global) { 
			$faqs_queries->posts = array_merge( $faqs_queries->posts, $faqs_queries_global->posts );
			$faqs_queries->post_count = $faqs_queries->post_count + $faqs_queries_global->post_count; 
		}
		if ($faqs_queries_current) {
			$faqs_queries->posts = array_merge( $faqs_queries->posts, $faqs_queries_current->posts );
			$faqs_queries->post_count = $faqs_queries->post_count + $faqs_queries_current->post_count;
		}

		return $faqs_queries;

	}
	
	/**
	 * Merge the posts from two separate wp_queries
	 *
	 * @since   1.0.0
	 * @param   Array   $faqs_queries_current           WP_Query object
	 * @param   Array   $faqs_queries_global            WP_Query object
	 * 
	 */
	private function list_grouped_faqs( $filter_array ) {

		// get current blog faq categories
		$faq_groups = get_terms( array( 'taxonomy' => 'faq-group', 'hide_empty' => true ) );

		// get global faq categories
		if ( get_current_blog_ID() != $this->global_faq_site && is_multisite() ) {

			switch_to_blog($this->global_faq_site);

				$faq_groups_global = get_terms( array( 'taxonomy' => 'faq-group', 'hide_empty' => true ) );

			restore_current_blog();

			$faq_groups_all = $this->merge_faq_groups($faq_groups, $faq_groups_global);
		}
		else {
			$faq_groups_all = $faq_groups;
		}

		if ( ! empty( $faq_groups_all ) && ! is_wp_error( $faq_groups_all ) ) {

			$faqs_queries = array();
			$query_index =  0;
			
			/**
			 * Create Index
			 */
			echo '<div id="ms-faqs-index" class="ms-faqs-index">';

			if (is_multisite()) {
				foreach ( $faq_groups_all as $faq_group ) {

					$current_faqs = true;
					$global_faqs = false;

					// display all if filter array is empty OR display only specified groups if filter array contains group slugs
					if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

						if ($this->faq_group_in_blog($faq_groups,$faq_group->slug)) {
							// should check if slug is in current terms
							$faqs_queries_current[$query_index] = new WP_Query( array(
									'post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array (
											'taxonomy' => 'faq-group',
											'field'    => 'slug',
											'terms'    => $faq_group->slug,
										)
									),
								)
							);
							// if this faq_group was in this blog there will be posts - as we only retrieved non-empty groups
							$current_faqs = true;
						}

						// if current slug is in original global slug list
						if ( get_current_blog_id() != $this->global_faq_site && $this->faq_group_in_blog($faq_groups_global,$faq_group->slug)) {
						
							switch_to_blog($this->global_faq_site);
							
							$faqs_queries_global[$query_index] = new WP_Query( array(
									'post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array (
											'taxonomy' => 'faq-group',
											'field'    => 'slug',
											'terms'    => $faq_group->slug    
										)
									),
									'meta_key' => 'global_faq', // get only global posts
									'meta_value' => 'on',     
								)
							);
							// this faq_group may not have had global posts - so need to check
							if ($faqs_queries_global[ $query_index ]->have_posts()) {
								$global_faqs = true;
							}

							restore_current_blog();


							if ($current_faqs && $global_faqs) {
								$faqs_queries[ $query_index ] = $this->merge_posts($faqs_queries_current[$query_index], $faqs_queries_global[$query_index]); 
							}
							elseif ($current_faqs && !$global_faqs) {
								$faqs_queries[ $query_index ] = $faqs_queries_current[$query_index];
							}
							elseif (!$current_faqs && $global_faqs) {
								$faqs_queries[ $query_index ] = $faqs_queries_global[$query_index];
							}
							else {
								// we mal have a faq_group from the main site with no global faqs...
								// $faq_queries[ $query_index ] will be null
							}
						}
						else {
							// use the original query if in main blog
							$faqs_queries[ $query_index ] = $faqs_queries_current[$query_index];
						}

						// FAQs index
						if ($faqs_queries[ $query_index ] &&  $faqs_queries[ $query_index ]->have_posts() ) : // check if current index is not null and has posts
							echo '<h4>' . $faq_group->name . '</h4>';
							echo '<ol class="ms-faqs-group-index ms-faqs-index-list">';
							while ( $faqs_queries[ $query_index ]->have_posts() ) :
								$faqs_queries[ $query_index ]->the_post();
								?><li><a href="#ms-faq-<?php the_ID(); ?>"><?php the_title(); ?></a></li><?php
							endwhile;
							echo '</ol>';
						endif; 

						$query_index++;

					}
				}
			}
			else { // if not multisite
				foreach ( $faq_groups_all as $faq_group ) {
					// display all if filter array is empty OR display only specified groups if filter array contains group slugs
					if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

						$faqs_queries[ $query_index ] = new WP_Query( array(
								'post_type' => 'faq',
								'posts_per_page' => -1,
								'tax_query' => array(
									array (
										'taxonomy' => 'faq-group',
										'field'    => 'slug',
										'terms'    => $faq_group->slug,
									)
								),
							)
						);

						// FAQs index
						if ( $faqs_queries[ $query_index ]->have_posts() ) :
							echo '<h4>' . $faq_group->name . '</h4>';
							echo '<ol class="ms-faqs-group-index ms-faqs-index-list">';
							while ( $faqs_queries[ $query_index ]->have_posts() ) :
								$faqs_queries[ $query_index ]->the_post();
								?><li><a href="#ms-faq-<?php the_ID(); ?>"><?php 'bbb' . the_title(); ?></a></li><?php
							endwhile;
							echo '</ol>';
						endif;

						$query_index++;

					}
				}
			}

			echo '</div>';
			
			/**
			 * Create Contents
			 */
			foreach ( $faqs_queries as $faqs_query ) {
				if ( $faqs_query ) :
					$faqs_query->rewind_posts();
					if ( $faqs_query->have_posts() ) :
						while ( $faqs_query->have_posts() ) :
							$faqs_query->the_post();
							?>
							<div id="ms-faq-<?php the_ID(); ?>" class="ms-faq-content">
								<h4><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
								<?php the_content(); // following p tag to fix display bug ?></p>
								<a class="ms-faq-top" href="#ms-faqs-index"><i class="fa fa-angle-up"></i> <?php _e( 'Back to Index', 'multisite-faqs'); ?></a>
							</div>
						<?php
						endwhile;
					endif;
				endif;
			}

			// All the custom loops ends here so reset the query
			wp_reset_query();

		}

	}


	/**
	 * Display FAQs in toggle style
	 *
	 * @since   1.0.0
	 * @param   Array   $filter_array   Array of faq groups slugs
	 */
	private function toggles_for_all_faqs( $filter_array ) {


		$faqs_query_args = array(
			'post_type' => 'faq',
			'posts_per_page' => -1,
		);

		if ( ! empty ( $filter_array ) ) {
			$faqs_query_args['tax_query'] = array(
				array (
					'taxonomy' => 'faq-group',
					'field'    => 'slug',
					'terms'    => $filter_array,
				),
			);
		}

		$faqs_query = new WP_Query( $faqs_query_args );

		// get main blog faqs only if we are not in blog main blog
		if (get_current_blog_ID() != $this->global_faq_site && is_multisite() ) {

			// set up args to get global faqs
			$faqs_query_args['meta_key'] = 'global_faq';
			$faqs_query_args['meta_value'] = 'on';

			switch_to_blog($this->global_faq_site);

				$faqs_query_global = new WP_Query( $faqs_query_args );

			restore_current_blog();

			// merge the posts if there are global posts in the main blog
			if ( $faqs_query_global->have_posts() ) {
				$faqs_query_final = $this->merge_posts($faqs_query, $faqs_query_global); 
			}
			else {
				$faqs_query_final = $faqs_query; 
			}
		}
		else {   
			// use the original query if in main blog
			$faqs_query_final = $faqs_query;  
		}

		// FAQs Toggles
		if ( $faqs_query_final->have_posts() ) :
			while ( $faqs_query_final->have_posts() ) :
				$faqs_query_final->the_post();
				?>
				<div class="ms-faq-toggle">
					<div class="ms-toggle-title">
						<strong><i class="fa fa-plus-circle"></i> <?php the_title(); ?></strong>
					</div>
					<div class="ms-toggle-content">
						<?php the_content(); ?>
					</div>
				</div>
			<?php
			endwhile;
		endif;

		// All the custom loops ends here so reset the query
		wp_reset_query();

	}

	/**
	 * Display toggle styles FAQs in groups
	 *
	 * @since   1.0.0
	 * @param   Array   $filter_array   Array of faq groups slugs
	 */
	private function toggles_grouped_faqs( $filter_array ) {

		$faq_groups = get_terms( array( 'taxonomy' => 'faq-group', 'hide_empty' => true ) );

		// get global faq categories
		if ( get_current_blog_ID() != $this->global_faq_site && is_multisite() ) {

			switch_to_blog($this->global_faq_site);

				$faq_groups_global = get_terms( array( 'taxonomy' => 'faq-group', 'hide_empty' => true ) );

			restore_current_blog();

			$faq_groups_all = $this->merge_faq_groups($faq_groups, $faq_groups_global);
		}
		else {
			$faq_groups_all = $faq_groups;
		}   
		

		if ( ! empty( $faq_groups_all ) && ! is_wp_error( $faq_groups_all ) ) {

			$faqs_queries = array();
			$faq_group_names = array();
			$query_index =  0;
			
			if ( is_multisite()) {
				foreach ( $faq_groups_all as $faq_group ) {

					$current_faqs = true;
					$global_faqs = false;

					// display all if filter array is empty OR display only specified groups if filter array contains group slugs
					if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

						// if this slug was in this blog there should be posts
						if ($this->faq_group_in_blog($faq_groups,$faq_group->slug)) {
							
							$faqs_queries_current[$query_index] = new WP_Query( array(
									'post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array (
											'taxonomy' => 'faq-group',
											'field'    => 'slug',
											'terms'    => $faq_group->slug,
										)
									),
								)
							);
							// if this faq_group was in this blog there will be posts - as we only retrieved non-empty groups
							$current_faqs = true;
						}

						// if current slug is in original global slug list
						if ( get_current_blog_id() != $this->global_faq_site && $this->faq_group_in_blog($faq_groups_global,$faq_group->slug)) {
						
							switch_to_blog($this->global_faq_site);
							
							$faqs_queries_global[$query_index] = new WP_Query( array(
									'post_type' => 'faq',
									'posts_per_page' => -1,
									'tax_query' => array(
										array (
											'taxonomy' => 'faq-group',
											'field'    => 'slug',
											'terms'    => $faq_group->slug    
										)
									),
									'meta_key' => 'global_faq', // get only global posts
									'meta_value' => 'on',     
								)
							);
							// this faq_group may not have had global posts - so need to check
							if ($faqs_queries_global[ $query_index ]->have_posts()) {
								$global_faqs = true;
							}

							restore_current_blog();

							if ($current_faqs && $global_faqs) {
								$faqs_queries[ $query_index ] = $this->merge_posts($faqs_queries_current[$query_index], $faqs_queries_global[$query_index]); 
							}
							elseif ($current_faqs && !$global_faqs) {
								$faqs_queries[ $query_index ] = $faqs_queries_current[$query_index];
							}
							elseif (!$current_faqs && $global_faqs) {
								$faqs_queries[ $query_index ] = $faqs_queries_global[$query_index];
							}
							else {
								// we mal have a faq_group from the main site with no global faqs...
								// $faq_queries[ $query_index ] will be null
							}
						
						}
						else {
							// use the original query if in main blog
							$faqs_queries[ $query_index ] = $faqs_queries_current[$query_index];  
						}

						$faq_group_names[ $query_index] = $faq_group->name;
						$query_index++;  
					
					}
				}
			}
			else {
				foreach ( $faq_groups_all as $faq_group ) {

					// display all if filter array is empty OR display only specified groups if filter array contains group slugs
					if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {
	
						$faqs_queries[$query_index] = new WP_Query( array(
								'post_type' => 'faq',
								'posts_per_page' => -1,
								'tax_query' => array(
									array (
										'taxonomy' => 'faq-group',
										'field'    => 'slug',
										'terms'    => $faq_group->slug,
									)
								),
							)
						);
	
						$faq_group_names[ $query_index] = $faq_group->name;
						$query_index++;
	
					}
	
				} 
			}


			// FAQs Toggles
			foreach ( $faqs_queries as $key =>$faqs_query ) {
				if ($faqs_query) :
					if ( $faqs_query->have_posts() ) :
						echo '<h4>' . $faq_group_names[$key] . '</h4>';
						echo '<div class="ms-faqs-toggles-group">';
						while ( $faqs_query->have_posts() ) :
							$faqs_query->the_post();
							?>
							<div class="ms-faq-toggle">
								<div class="ms-toggle-title">
									<strong><i class="fa fa-plus-circle"></i> <?php the_title(); ?></strong>
								</div>
								<div class="ms-toggle-content">
									<?php the_content(); ?>
								</div>
							</div>
							<?php
						endwhile;
						echo '</div>';
					endif;
				endif;
			}

			// All the custom loops ends here so reset the query
			wp_reset_query();

		}

	}

}

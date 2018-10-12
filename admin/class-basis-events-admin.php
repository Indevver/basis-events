<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://indevver.com
 * @since      1.0.0
 *
 * @package    Basis_Events
 * @subpackage Basis_Events/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Basis_Events
 * @subpackage Basis_Events/admin
 * @author     Jeremy Ross <jeremy@indevver.com>
 */
class Basis_Events_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Basis_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Basis_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/basis-events-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Basis_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Basis_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/basis-events-admin.js', array( 'jquery' ), $this->version, false );

	}

	public static function register_events() {
		register_extended_post_type( 'event', [
			'menu_icon' => 'dashicons-calendar-alt',

			'admin_cols' => [
				'featured_image' => [
					'title' => 'Featured',
					'featured_image' => 'thumbnail',
					'width' => '60',
					'height' => '60',
				],
				'title' => [
					'title' => 'Event Name'
				],
				'type' => [
					'taxonomy' => 'event_type'
				],
				'start_date' => [
					'title'       => 'Start Date',
					'meta_key'    => 'start_date',
					'date_format' => 'm/d/Y'
				],
				'featured_event' => [
					'title'       => 'Featured?',
					'function'  => function() {
						echo get_field('featured_event') ? '<span class="dashicons dashicons-star-filled"></span>' : '' ;
					},
				],

			],

			'admin_filters' => [
				'type' => [
					'taxonomy' => 'event_type'
				]
			]
		] );

		register_extended_taxonomy( 'event_type', 'event', [], [
			'singular' => 'Event Type',
			'plural'   => 'Event Types',
			'slug'     => 'event-types'
		] );
	}

	public static function setFeatured( $post_id, $post, $update ) {
		$numFeatured = 3;

		$featured = new WP_Query( [
			'post_type'      => [ 'event' ],
			'posts_per_page' => $numFeatured,
			'fields'         => 'ids',
			'orderby'        => "DESC",
			'meta_query'     => [
				[
					'key'     => 'featured_event',
					'value'   => true,
					'compare' => '=',
				],
			],
		] );

		update_option( 'featured_event', $featured->posts );
	}
}

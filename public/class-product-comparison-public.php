<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/shaon-hossain45
 * @since      1.0.0
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/public
 * @author     Shaon Hossain <shaonhossain615@gmail.com>
 */
class Product_Comparison_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->public_load_dependencies();

		if ( class_exists( 'PublicBaseSetup' ) ) {
			new PublicBaseSetup();
		}
		if ( class_exists( 'PublicBaseDisplay' ) ) {
			new PublicBaseDisplay();
		}

	}

	/**
	 * Directory path called
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	private function public_load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/product-comparison-public-display.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/product-comparison-public-setup.php';
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Comparison_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Comparison_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css', array(), '6.2.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-comparison-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Comparison_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Comparison_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jQuery-int', plugin_dir_url( __FILE__ ) . 'js/vendor/jquery-3.5.1.min.js', array( '' ), '3.5.1', true );

		wp_enqueue_script( 'product-public', plugin_dir_url( __FILE__ ) . 'js/product-public.js', array( 'jquery' ), $this->version, true );
		
		wp_enqueue_script( 'product-comparison-public', plugin_dir_url( __FILE__ ) . 'js/product-comparison-public.js', array( 'jquery' ), $this->version, true );

		$ajax_nonce = wp_create_nonce( 'product_comp_nonce' );

				wp_localize_script(
					'product-comparison-public',
					'pluginkl888l_obj',
					array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'action'   => 'compare_table_update_setting',
						'security' => $ajax_nonce,
					)
				);

				wp_enqueue_script( 'product-filter-public', plugin_dir_url( __FILE__ ) . 'js/product-filter-public.js', array( 'jquery' ), $this->version, true );
				$ajax_noncefilter = wp_create_nonce( 'product_filter_nonce' );

				wp_localize_script(
					'product-filter-public',
					'pluginkpoo_obj',
					array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'action'   => 'filter_update_setting',
						'security' => $ajax_noncefilter,
					)
				);

	}

}

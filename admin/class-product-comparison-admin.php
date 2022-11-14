<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/shaon-hossain45
 * @since      1.0.0
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/admin
 * @author     Shaon Hossain <shaonhossain615@gmail.com>
 */
class Product_Comparison_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->admin_load_dependencies();

		if ( class_exists( 'AdminBaseSetup' ) ) {
			new AdminBaseSetup();
		}
		// if ( class_exists( 'AdminBaseAttributes' ) ) {
		// 	new AdminBaseAttributes();
		// }
		if ( class_exists( 'AdminBaseAttributesTaxonomy' ) ) {
			new AdminBaseAttributesTaxonomy();
		}

	}


	/**
	 * Directory path called
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	private function admin_load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/product-comparison-admin-display.php';
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/product-comparison-admin-attributes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/product-comparison-admin-attributes-taxonomy.php';
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
		 * defined in Product_Comparison_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Comparison_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-comparison-admin.css', array(), $this->version, 'all' );

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
		 * defined in Product_Comparison_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Comparison_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-comparison-admin.js', array( 'jquery' ), $this->version, false );

	}

}

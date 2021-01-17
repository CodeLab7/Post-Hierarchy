<?php

class Posthierarchy {
	protected $loader;

	public function __construct() {
		$this->load_dependencies();
		//$this->set_locale();
		$this->define_admin_hooks();
		//$this->define_public_hooks();
		//$this->create_master_settings();
		//$this->create_custom_post();
		$this->support();
	}

	private function define_public_hooks() {
		$plugin_public = new Posthierarchy_Public();
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	private function define_admin_hooks() {
		$plugin_admin = new Posthierarchy_Admin();
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        //$this->loader->add_action( 'activated_plugin', $plugin_admin, 'activation_redirect' );
        //add_action( 'init',array($this,'activate_child_post_by_option'));
        $this->loader->add_action( 'registered_post_type', $plugin_admin, 'enable_hierarchy_fields', 123, 2);
        $this->loader->add_filter( 'post_type_labels_post', $plugin_admin, 'enable_hierarchy_fields_for_js', 11, 2);
        $this->loader->add_filter( 'pre_post_link', $plugin_admin, 'change_permalinks', 8, 3 );
        $this->loader->add_action( 'registered_post_type',	$plugin_admin, 'method__modify_post_obj', 150 , 2);
    }

    private function create_master_settings() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/Posthierarchy_Settings.php';
		$setting_page = new Posthierarchy_Settings( 'Developer API' );
		/**
		 * How to use Settings Page:
		 * Use following to create option fields.
		 * Available Options are: text, textarea, password, checkbox
		 * */

		$setting_page->add_section( 'Security' );
		$setting_page->add_option( 'Activate Child Option in Post', 'checkbox' );

		/**
		 * Below are setting to set menu and options
		 */
		$this->loader->add_action( 'admin_init', $setting_page, 'init_settings' );
		$this->loader->add_action( 'admin_menu', $setting_page, 'add_setting_page' );
	}

	private function support() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'support/CL7_Support.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'support/CL7_Settings.php';
		$support_settings = new CL7_Settings();
		$this->loader->add_action( 'admin_init', $support_settings, 'init_settings' );
		$this->loader->add_action( 'admin_menu', $support_settings, 'add_setting_page' );
		$cl7 = new CL7_Support();
		$this->loader->add_action( 'admin_footer', $cl7, 'feedback_widget_admin' );
		$this->loader->add_action( 'wp_footer', $cl7, 'feedback_widget' );
	}

	private function create_custom_post() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/Posthierarchy_CustomPost.php';
		$post = new Posthierarchy_CustomPost();
		$post->set_post_type( 'post' );
		$post->create_cate( 'Hello World' ); //It will create a taxonomy for above post type
		$post->create_tag( 'Hello Master' );

		$post->create_custom_post( 'custom post', [] ); //You can add configure into this
		$post->create_cate( 'Hello World' ); //It will create a taxonomy for above post type

		$post->create_custom_page( 'custom page' );
		$this->loader->add_action( 'init', $post, 'register' );
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Posthierarchy_Loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Posthierarchy_Abstruct.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/Posthierarchy_Admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/Posthierarchy_Public.php';
		$this->loader = new Posthierarchy_Loader();
	}

	private function set_locale() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Posthierarchy_i18n.php';
		$plugin_i18n = new Posthierarchy_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	public function run() {
		$this->loader->run();
	}

}

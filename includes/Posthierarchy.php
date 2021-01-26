<?php

class Posthierarchy {

    protected $loader;

    public function __construct() {
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Posthierarchy_Admin();
        $this->loader->add_action('registered_post_type', $plugin_admin, 'enable_hierarchy_fields', 123, 2);
        $this->loader->add_filter('post_type_labels_post', $plugin_admin, 'change_labels', 11, 2);
        $this->loader->add_filter('pre_post_link', $plugin_admin, 'change_permalinks', 8, 3);

    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Posthierarchy_Loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/Posthierarchy_Admin.php';
        $this->loader = new Posthierarchy_Loader();
    }

    private function set_locale() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Posthierarchy_i18n.php';
        $plugin_i18n = new Posthierarchy_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    public function run() {
        $this->loader->run();
    }

}

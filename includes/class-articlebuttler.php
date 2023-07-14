<?php
/**
 * ArticleButtler Class
 *
 * Responsible for setting up the main functionality of the ArticleButtler plugin.
 */
class ArticleButtler {

    /**
     * Plugin version.
     *
     * @var string
     */
    private $version = '1.0.0';

    /**
     * Initialize the plugin.
     */
    public function __construct() {
        $this->register_hooks();
    }

    /**
     * Register the plugin hooks.
     */
    private function register_hooks() {
        // Register activation and deactivation hooks.
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Register plugin initialization hook.
        add_action('init', array($this, 'initialize_plugin'));
    }

    /**
     * Activate the plugin.
     */
    public function activate() {
        // Perform activation tasks here.
    }

    /**
     * Deactivate the plugin.
     */
    public function deactivate() {
        // Perform deactivation tasks here.
    }

    /**
     * Initialize the plugin.
     */
    public function initialize_plugin() {
        // Load required files.
        require_once plugin_dir_path(__FILE__) . 'class-articlebuttler-settings.php';
        require_once plugin_dir_path(__FILE__) . 'class-articlebuttler-generator.php';
        require_once plugin_dir_path(__FILE__) . 'class-articlebuttler-image-generator.php';
        require_once plugin_dir_path(__FILE__) . 'class-articlebuttler-article-generator.php';

        // Initialize plugin components.
        $settings = new ArticleButtler_Settings();
        $settings->init();

        $generator = new ArticleButtler_Generator();
        $generator->init();
    }
}

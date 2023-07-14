<?php
/**
 * Plugin Name: ArticleButtler
 * Description: An advanced WordPress plugin for generating custom articles and images.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define the ArticleButtler plugin class.
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
        // Load plugin dependencies.
        add_action('plugins_loaded', array($this, 'load_dependencies'));

        // Initialize the plugin.
        add_action('init', array($this, 'initialize_plugin'));
    }

    /**
     * Load plugin dependencies.
     */
    public function load_dependencies() {
        // Load necessary files and classes here.
        require_once plugin_dir_path(__FILE__) . 'includes/class-articlebuttler-settings.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-articlebuttler-generator.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-articlebuttler-image-generator.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-articlebuttler-article-generator.php';
    }

    /**
     * Initialize the plugin.
     */
    public function initialize_plugin() {
        // Register and enqueue plugin scripts and styles.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));

        // Initialize the plugin settings.
        $settings = new ArticleButtler_Settings();
        $settings->init();

        // Initialize the generator.
        $generator = new ArticleButtler_Generator();
        $generator->init();
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_style('articlebuttler-admin', plugin_dir_url(__FILE__) . 'admin/css/articlebuttler-admin.css', array(), $this->version);
        wp_enqueue_script('articlebuttler-admin', plugin_dir_url(__FILE__) . 'admin/js/articlebuttler-admin.js', array('jquery'), $this->version, true);
    }

    /**
     * Enqueue public scripts and styles.
     */
    public function enqueue_public_scripts() {
        wp_enqueue_style('articlebuttler-public', plugin_dir_url(__FILE__) . 'public/css/articlebuttler-public.css', array(), $this->version);
        wp_enqueue_script('articlebuttler-public', plugin_dir_url(__FILE__) . 'public/js/articlebuttler-public.js', array('jquery'), $this->version, true);
    }
}

// Instantiate the ArticleButtler plugin.
$article_buttler = new ArticleButtler();

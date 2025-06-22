<?php
/**
 * Plugin Name: ArticleButtler
 * Description: An advanced WordPress plugin for generating custom articles and images.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define the ArticleButtlerPlugin class.
class ArticleButtlerPlugin {
    /**
     * Plugin version.
     *
     * @var string
     */
    private $version = '1.1.0';

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
        require_once plugin_dir_path(__FILE__) . 'includes/class-articlebuttler-admin.php'; // Include the ArticleButtler_Admin class file.
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

        // Initialize the image generator using selected library.
        $options         = get_option('articlebuttler_options');
        $library         = isset($options['image_library']) ? $options['image_library'] : 'gd';
        $image_generator = new ArticleButtler_Image_Generator($library);
        $image_generator->init();

        // Initialize the admin functionality.
        $admin = new ArticleButtler_Admin();
        $admin->init();

        // Register shortcode for front-end display.
        add_shortcode('articlebuttler', array($this, 'render_public_interface'));
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_style('articlebuttler-admin', plugin_dir_url(__FILE__) . 'admin/css/articlebuttler-admin.css', array(), $this->version);
        wp_enqueue_script('articlebuttler-admin', plugin_dir_url(__FILE__) . 'admin/js/articlebuttler-admin.js', array('jquery'), $this->version, true);

        wp_localize_script('articlebuttler-admin', 'articlebuttler_vars', array(
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'article_nonce' => wp_create_nonce('articlebuttler_generate_article'),
            'image_nonce'   => wp_create_nonce('articlebuttler_generate_image'),
        ));
    }

    /**
     * Enqueue public scripts and styles.
     */
    public function enqueue_public_scripts() {
        wp_enqueue_style('articlebuttler-public', plugin_dir_url(__FILE__) . 'public/css/articlebuttler-public.css', array(), $this->version);
        wp_enqueue_script('articlebuttler-public', plugin_dir_url(__FILE__) . 'public/js/articlebuttler-public.js', array('jquery'), $this->version, true);

        wp_localize_script('articlebuttler-public', 'articlebuttler_public_vars', array(
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'article_nonce' => wp_create_nonce('articlebuttler_generate_article'),
            'image_nonce'   => wp_create_nonce('articlebuttler_generate_image'),
        ));
    }

    /**
     * Render the shortcode output.
     */
    public function render_public_interface() {
        ob_start();
        include plugin_dir_path(__FILE__) . 'public/partials/articlebuttler-public-display.php';
        return ob_get_clean();
    }
}

// Instantiate the ArticleButtlerPlugin class.
$article_buttler = new ArticleButtlerPlugin();


// Plugin activation hook
register_activation_hook(__FILE__, 'articlebuttler_activate');

// Plugin deactivation hook
register_deactivation_hook(__FILE__, 'articlebuttler_deactivate');

// Plugin activation callback
function articlebuttler_activate() {
    // Perform activation tasks, if any
}

// Plugin deactivation callback
function articlebuttler_deactivate() {
    // Perform deactivation tasks, if any
}


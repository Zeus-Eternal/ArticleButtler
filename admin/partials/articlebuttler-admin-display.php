<?php
/**
 * ArticleButtler Admin Display
 *
 * Handles the display of the ArticleButtler admin page.
 */

// Retrieve the plugin options
$options = get_option('articlebuttler_options');

// Check if the options exist and retrieve the prompt and image library
$prompt = isset($options['prompt']) ? $options['prompt'] : '';
$image_library = isset($options['image_library']) ? $options['image_library'] : 'gd';
?>

<div class="wrap articlebuttler-wrapper">
    <h1 class="articlebuttler-heading">ArticleButtler</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('articlebuttler_settings_group');
        do_settings_sections('articlebuttler-settings');
        submit_button();
        ?>
    </form>

    <h2><?php esc_html_e('Generate Article', 'articlebuttler'); ?></h2>
    <input type="text" id="articlebuttler-prompt" class="articlebuttler-prompt-input" value="<?php echo esc_attr($prompt); ?>" placeholder="Enter your prompt">
    <button class="articlebuttler-generate-button">Generate Article</button>
    <div class="articlebuttler-generated-content"></div>
</div>

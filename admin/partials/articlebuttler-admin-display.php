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

<div class="articlebuttler-wrapper">
    <h2 class="articlebuttler-heading">ArticleButtler Settings</h2>

    <label for="articlebuttler-prompt">Prompt:</label>
    <input type="text" id="articlebuttler-prompt" class="articlebuttler-prompt-input" value="<?php echo esc_attr($prompt); ?>">

    <label for="articlebuttler-image-library">Image Library:</label>
    <select id="articlebuttler-image-library" class="articlebuttler-image-library">
        <option value="gd" <?php selected($image_library, 'gd'); ?>>GD</option>
        <option value="imagick" <?php selected($image_library, 'imagick'); ?>>Imagick</option>
        <option value="api" <?php selected($image_library, 'api'); ?>>API</option>
    </select>

    <button class="articlebuttler-generate-button">Generate Article</button>

    <div class="articlebuttler-generated-content"></div>
</div>

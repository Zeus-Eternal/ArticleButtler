<?php
/**
 * ArticleButtler Public Display
 *
 * Handles the display of the ArticleButtler public interface.
 */

// Retrieve the plugin options
$options = get_option('articlebuttler_options');

// Check if the options exist and retrieve the prompt
$prompt = isset($options['prompt']) ? $options['prompt'] : '';
?>

<div class="articlebuttler-wrapper">
    <h2 class="articlebuttler-heading">ArticleButtler</h2>

    <input type="text" id="articlebuttler-prompt" class="articlebuttler-prompt-input" placeholder="Enter your prompt..." value="<?php echo esc_attr($prompt); ?>">

    <button class="articlebuttler-generate-button">Generate Article</button>

    <div class="articlebuttler-generated-content"></div>
</div>

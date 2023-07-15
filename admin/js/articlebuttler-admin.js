/**
 * ArticleButtler Admin JS
 */
jQuery(document).ready(function($) {
    // Handle generate button click event
    $('.articlebuttler-generate-button').on('click', function() {
        // Get the prompt input value
        var prompt = $('.articlebuttler-prompt-input').val();

        // Perform AJAX request to generate article
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'generate_article',
                prompt: prompt,
                nonce: articlebuttler_vars.nonce
            },
            beforeSend: function() {
                // Show loading spinner or any other UI indication
            },
            success: function(response) {
                // Process the response
                if (response.success) {
                    // Display the generated article
                    $('.articlebuttler-generated-content').html(response.article);
                } else {
                    // Display an error message
                    alert('Failed to generate the article. Please try again.');
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                // Display an error message
                alert('Failed to generate the article. Please try again.');
            },
            complete: function() {
                // Hide loading spinner or any other UI indication
            }
        });
    });
});

jQuery(document).ready(function($) {
    // Get options from PHP localized script
    var options = window.NeonMarkCompleteOptions || {};

    // When the mark complete button is clicked
    $('.mark-complete-button').on('click', function() {
        var button = $(this);
        var postId = button.data('post-id');
        var userId = button.data('user-id');

        // Change label to 'Saving...'
        button.text(options.savingLabel);

        // AJAX request to save completion status
        $.ajax({
            url: options.ajaxUrl,
            type: 'POST',
            data: {
                action: 'mark_complete',
                post_id: postId,
                user_id: userId,
                nonce: options.nonce
            },
            success: function(response) {
                if (response.success) {
                    // console.log(response.data.saved_label);
                    button.text(response.data.saved_label).prop('disabled', true);
                } else {
                    button.text('Error');
                }
            }
        });
    });
});

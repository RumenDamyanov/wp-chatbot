/**
 * All of the JavaScript for the admin area functionality of the
 * WP Chatbot plugin should be written in this file.
 *
 * @package    WpChatbot
 * @author     Rumen Damyanov <hey@rumenx.com>
 */

(function($) {
    'use strict';

    /**
     * Initialize admin functionality
     */
    $(document).ready(function() {
        initializeColorPicker();
        initializeFormValidation();
        initializePreview();
    });

    /**
     * Initialize color picker for primary color field
     */
    function initializeColorPicker() {
        const colorInput = $('#wp-chatbot-primary_color');

        if (colorInput.length) {
            colorInput.on('change', function() {
                updatePreviewColor($(this).val());
            });
        }
    }

    /**
     * Form validation
     */
    function initializeFormValidation() {
        $('form[name="wp_chatbot_options"]').on('submit', function(e) {
            let isValid = true;

            // Validate greeting message
            const greetingMessage = $('#wp-chatbot-greeting_message').val().trim();
            if (greetingMessage.length === 0) {
                alert('Please enter a greeting message.');
                isValid = false;
            }

            // Validate color
            const primaryColor = $('#wp-chatbot-primary_color').val();
            if (!/^#[0-9A-F]{6}$/i.test(primaryColor)) {
                alert('Please enter a valid hex color code.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    /**
     * Initialize live preview functionality
     */
    function initializePreview() {
        // Add a preview button if not exists
        if ($('#wp-chatbot-preview').length === 0) {
            $('.wp-chatbot-settings-section').first().append(
                '<div style="margin-top: 20px;">' +
                '<button type="button" id="wp-chatbot-preview" class="button button-secondary">' +
                'Preview Chatbot' +
                '</button>' +
                '</div>'
            );
        }

        $('#wp-chatbot-preview').on('click', function(e) {
            e.preventDefault();
            showPreview();
        });
    }

    /**
     * Show chatbot preview
     */
    function showPreview() {
        const settings = {
            theme: $('#wp-chatbot-theme').val(),
            position: $('#wp-chatbot-position').val(),
            greeting_message: $('#wp-chatbot-greeting_message').val(),
            primary_color: $('#wp-chatbot-primary_color').val(),
            animation: $('#wp-chatbot-animation').val()
        };

        // Create preview modal
        const modal = $('<div>', {
            id: 'wp-chatbot-preview-modal',
            css: {
                position: 'fixed',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                zIndex: 999999,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            }
        });

        const previewContent = $('<div>', {
            css: {
                backgroundColor: '#fff',
                padding: '20px',
                borderRadius: '8px',
                position: 'relative',
                maxWidth: '400px',
                width: '90%'
            },
            html: '<h3>Chatbot Preview</h3>' +
                  '<p>Theme: ' + settings.theme + '</p>' +
                  '<p>Position: ' + settings.position + '</p>' +
                  '<p>Primary Color: <span style="display: inline-block; width: 20px; height: 20px; background-color: ' + settings.primary_color + '; margin-left: 10px;"></span></p>' +
                  '<div style="border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 4px;">' +
                  '<strong>Greeting:</strong><br>' + settings.greeting_message +
                  '</div>' +
                  '<button type="button" id="close-preview" class="button">Close Preview</button>'
        });

        modal.append(previewContent);
        $('body').append(modal);

        // Close preview
        $('#close-preview, #wp-chatbot-preview-modal').on('click', function(e) {
            if (e.target === this) {
                modal.remove();
            }
        });
    }

    /**
     * Update preview color
     */
    function updatePreviewColor(color) {
        // This would update any live preview elements
        $('.wp-chatbot-preview-element').css('color', color);
    }

})(jQuery);

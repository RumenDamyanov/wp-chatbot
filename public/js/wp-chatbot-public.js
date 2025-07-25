/**
 * All of the JavaScript for the public-facing functionality of the
 * WP Chatbot plugin should be written in this file.
 *
 * @package    WpChatbot
 * @author     Rumen Damyanov <hey@rumenx.com>
 */

(function($) {
    'use strict';

    /**
     * Chatbot functionality
     */
    class WpChatbot {
        constructor() {
            this.container = $('#wp-chatbot-container');
            this.toggle = $('#wp-chatbot-toggle');
            this.window = $('#wp-chatbot-window');
            this.messagesContainer = $('#wp-chatbot-messages');
            this.input = $('#wp-chatbot-input');
            this.form = $('#wp-chatbot-form');
            this.typing = $('#wp-chatbot-typing');
            this.sessionId = this.generateSessionId();
            this.isOpen = false;

            this.init();
        }

        /**
         * Initialize chatbot
         */
        init() {
            this.bindEvents();
            this.setupKeyboardShortcuts();
            this.loadSettings();
        }

        /**
         * Bind event listeners
         */
        bindEvents() {
            // Toggle chatbot
            this.toggle.on('click', () => this.toggleChatbot());

            // Minimize button
            $('.wp-chatbot-minimize').on('click', () => this.closeChatbot());

            // Form submission
            this.form.on('submit', (e) => this.handleFormSubmit(e));

            // Input focus management
            this.input.on('keypress', (e) => {
                if (e.which === 13) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });

            // Close on escape key
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.closeChatbot();
                }
            });

            // Handle shortcode forms
            $('.wp-chatbot-shortcode-form').on('submit', (e) => this.handleShortcodeSubmit(e));
        }

        /**
         * Setup keyboard shortcuts
         */
        setupKeyboardShortcuts() {
            $(document).on('keydown', (e) => {
                // Ctrl/Cmd + Shift + C to toggle chatbot
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'C') {
                    e.preventDefault();
                    this.toggleChatbot();
                }
            });
        }

        /**
         * Load settings from localized script
         */
        loadSettings() {
            if (typeof wp_chatbot_ajax !== 'undefined') {
                this.settings = wp_chatbot_ajax.settings;
                this.applySettings();
            }
        }

        /**
         * Apply settings to chatbot
         */
        applySettings() {
            if (!this.settings) return;

            // Apply primary color
            if (this.settings.primary_color) {
                this.container[0].style.setProperty('--wp-chatbot-primary-color', this.settings.primary_color);
            }

            // Apply mobile settings
            if (!this.settings.show_on_mobile && this.isMobile()) {
                this.container.hide();
            }
        }

        /**
         * Toggle chatbot open/close
         */
        toggleChatbot() {
            if (this.isOpen) {
                this.closeChatbot();
            } else {
                this.openChatbot();
            }
        }

        /**
         * Open chatbot
         */
        openChatbot() {
            this.container.addClass('wp-chatbot-open');
            this.isOpen = true;

            // Focus input after animation
            setTimeout(() => {
                this.input.focus();
            }, 300);

            // Scroll to bottom
            this.scrollToBottom();
        }

        /**
         * Close chatbot
         */
        closeChatbot() {
            this.container.removeClass('wp-chatbot-open');
            this.isOpen = false;
            this.input.blur();
        }

        /**
         * Handle form submission
         */
        handleFormSubmit(e) {
            e.preventDefault();
            this.sendMessage();
        }

        /**
         * Handle shortcode form submission
         */
        handleShortcodeSubmit(e) {
            e.preventDefault();
            const form = $(e.target);
            const input = form.find('.wp-chatbot-input');
            const messagesContainer = form.closest('.wp-chatbot-shortcode').find('.wp-chatbot-shortcode-messages');

            this.sendMessage(input.val(), messagesContainer, input);
        }

        /**
         * Send message
         */
        sendMessage(messageText = null, customContainer = null, customInput = null) {
            const message = messageText || this.input.val().trim();
            const container = customContainer || this.messagesContainer;
            const input = customInput || this.input;

            if (!message) return;

            // Add user message to chat
            this.addMessage(message, 'user', container);

            // Clear input
            input.val('');

            // Show typing indicator
            this.showTyping();

            // Send AJAX request
            this.sendAjaxMessage(message, container);
        }

        /**
         * Send AJAX message to backend
         */
        sendAjaxMessage(message, container) {
            $.ajax({
                url: wp_chatbot_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'wp_chatbot_send_message',
                    message: message,
                    session_id: this.sessionId,
                    nonce: wp_chatbot_ajax.nonce
                },
                success: (response) => {
                    this.hideTyping();

                    if (response.success) {
                        this.addMessage(response.data.response, 'bot', container);
                    } else {
                        this.addMessage('Sorry, I encountered an error. Please try again.', 'bot', container);
                    }
                },
                error: () => {
                    this.hideTyping();
                    this.addMessage('Sorry, I\'m having trouble connecting. Please try again later.', 'bot', container);
                }
            });
        }

        /**
         * Add message to chat
         */
        addMessage(message, type, container = null) {
            const messagesContainer = container || this.messagesContainer;
            const timestamp = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            const messageHtml = `
                <div class="wp-chatbot-message wp-chatbot-message-${type}">
                    <div class="wp-chatbot-message-content">${this.escapeHtml(message)}</div>
                    <div class="wp-chatbot-message-time">${timestamp}</div>
                </div>
            `;

            messagesContainer.append(messageHtml);
            this.scrollToBottom(messagesContainer);
        }

        /**
         * Show typing indicator
         */
        showTyping() {
            this.typing.show();
            this.scrollToBottom();
        }

        /**
         * Hide typing indicator
         */
        hideTyping() {
            this.typing.hide();
        }

        /**
         * Scroll to bottom of messages
         */
        scrollToBottom(container = null) {
            const target = container || this.messagesContainer;
            setTimeout(() => {
                target.scrollTop(target[0].scrollHeight);
            }, 100);
        }

        /**
         * Generate unique session ID
         */
        generateSessionId() {
            return 'wp-chatbot-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        }

        /**
         * Check if device is mobile
         */
        isMobile() {
            return window.innerWidth <= 768;
        }

        /**
         * Escape HTML to prevent XSS
         */
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    }

    /**
     * Initialize chatbot when DOM is ready
     */
    $(document).ready(function() {
        if ($('#wp-chatbot-container').length) {
            new WpChatbot();
        }
    });

    /**
     * Global function for programmatic access
     */
    window.WpChatbot = {
        open: function() {
            $('#wp-chatbot-toggle').trigger('click');
        },
        close: function() {
            if ($('#wp-chatbot-container').hasClass('wp-chatbot-open')) {
                $('#wp-chatbot-toggle').trigger('click');
            }
        },
        sendMessage: function(message) {
            const input = $('#wp-chatbot-input');
            input.val(message);
            $('#wp-chatbot-form').trigger('submit');
        }
    };

})(jQuery);

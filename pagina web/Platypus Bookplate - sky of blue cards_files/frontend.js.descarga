/**
 * WooCommerce Custom Fields Plugin Frontend Scripts
 */
jQuery(document).ready(function() {

    /**
     * Dynamic price update on configuration change
     */
    if (rp_wccf_general_config.display_total_price) {

        // Key up
        // TBD: Add delay to not query server on each key stroke
        jQuery('form .wccf_product').keyup(function() {
            update_price(jQuery(this));
        });

        // Value change
        jQuery('form .wccf_product').change(function() {
            update_price(jQuery(this));
        });
    }

    /**
     * Dynamic price update on variable product variation change
     */
    jQuery('.variations_form').on('woocommerce_variation_has_changed', function(event) {
        update_price(jQuery('.variations_form'));        
    });

    /**
     * Update price
     * TBD: if page reloads after adding configured product to cart, old price
     * is displayed although all values are set (in case user is not redirected to cart)
     */
    function update_price(field) {

        // Send request
        jQuery.post(
            rp_wccf_general_config.ajaxurl,
            {
                'action': 'rp_wccf_product_price_update',
                'data': field.closest('form').serialize()
            },
            function(response) {

                // Parse response
                response = jQuery.parseJSON(response);

                // Replace price if no error was received
                if (typeof response.error === 'undefined' || !response.error) {
                    jQuery('form.cart dl.wccf_grand_total dd').html(response.price_html);
                }
            }
        );
    }

    /**
     * Toggle character limit
     */
    jQuery('.wccf[maxlength]').each(function() {
        var character_limit_element = jQuery(this).closest('.wccf_field_container').find('.wccf_character_limit');

        if (character_limit_element.length) {
            jQuery(this).focus(function() {
                character_limit_element.show();
            });
            jQuery(this).focusout(function() {
                character_limit_element.hide();
            });
        }
    });

    /**
     * Update characters remaining
     */
    function update_characters_remaining(field)
    {
        var character_limit_element = field.closest('.wccf_field_container').find('.wccf_character_limit');

        if (character_limit_element.length) {
            var limit = field.prop('maxlength');
            var remaining = limit - field.val().length;
            field.closest('.wccf_field_container').find('.wccf_characters_remaining').html(remaining);
        }
    }
    jQuery('.wccf[maxlength]').keyup(function() {
        update_characters_remaining(jQuery(this));
    });
    jQuery('.wccf[maxlength]').change(function() {
        update_characters_remaining(jQuery(this));
    });

});

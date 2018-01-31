/**
 * WooCommerce Custom Fields Plugin General Scripts
 */
jQuery(document).ready(function() {

    /**
     * Datepicker
     */
    jQuery('.wccf_date').each(function() {
        jQuery(this).datepicker(rp_wccf_datepicker_config);
    });

    /**
     * Check frontend conditions
     */
    function check_conditions(form)
    {
        // Iterate over all custom fields in this form
        form.find('.wccf').each(function() {

            // Get element id and conditions variable name
            var id = jQuery(this).prop('id');
            var conditions = 'wccf_conditions_' + id;

            // Check if we have any conditions for this field
            if (typeof window[conditions] !== 'undefined') {

                // Track if all conditions match
                var conditions_match = true;

                // Reference context
                var context = window[conditions]['context'];

                // Iterate over conditions
                for (var i = 0; i < window[conditions]['conditions'].length; i++) {

                    // Reference current condition and context
                    var condition = window[conditions]['conditions'][i];

                    // Check if condition is matched
                    if (!check_condition(form, condition, context)) {
                        conditions_match = false;
                    }
                }

                // Make field visible
                if (conditions_match && !form.find('#' + id).is(':visible')) {
                    jQuery('#' + id).closest('.wccf_meta_box_field_container, .wccf_field_container').each(function() {

                        // Enable fields so they are submitted
                        jQuery(this).find('input, select, textarea').removeAttr('disabled');

                        // Show field
                        jQuery(this).show();
                    });
                }
                // Make field hidden
                else if (!conditions_match && form.find('#' + id).is(':visible')) {
                    jQuery('#' + id).closest('.wccf_meta_box_field_container, .wccf_field_container').each(function() {

                        // Hide field
                        jQuery(this).hide();

                        // Disable fields so they are not submitted
                        jQuery(this).find('input, select, textarea').attr('disabled', 'disabled');

                        // TBD: currently this does not support chained conditions
                    });
                }
            }
        });
    }

    /**
     * Check single frontend condition
     */
    function check_condition(form, condition, context)
    {
        if (condition.type === 'custom_field_other_custom_field') {
            return check_condition_other_custom_field(form, condition, context);
        }

        return false;
    }

    /**
     * Check other custom field condition
     */
    function check_condition_other_custom_field(form, condition, context)
    {
        // Reference field that we are checking against
        var other_field = form.find('#wccf_' + context + '_' + condition.other_field_key);

        // Reference method
        var method = condition.custom_field_other_custom_field_method;

        // Is Empty
        if (method === 'is_empty') {
            return is_empty(form, other_field);
        }

        // Is Not Empty
        else if (method === 'is_not_empty') {
            return !is_empty(form, other_field);
        }

        // Contains
        else if (method === 'contains') {
            return contains(form, other_field, condition.text);
        }

        // Does Not Contain
        else if (method === 'does_not_contain') {
            return !contains(form, other_field, condition.text);
        }

        // Equals
        else if (method === 'equals') {
            return equals(form, other_field, condition.text);
        }

        // Does Not Equal
        else if (method === 'does_not_equal') {
            return !equals(form, other_field, condition.text);
        }

        // Less Than
        else if (method === 'less_than') {
            return less_than(form, other_field, condition.text);
        }

        // Less Or Equal To
        else if (method === 'less_or_equal_to') {
            return !more_than(form, other_field, condition.text);
        }

        // More Than
        else if (method === 'more_than') {
            return more_than(form, other_field, condition.text);
        }

        // More Or Equal
        else if (method === 'more_or_equal') {
            return !less_than(form, other_field, condition.text);
        }

        // Is Checked
        else if (method === 'is_checked') {
            return is_checked(form, other_field);
        }

        // Is Not Checked
        else if (method === 'is_not_checked') {
            return !is_checked(form, other_field);
        }
    }

    /**
     * Check if field element is empty
     */
    function is_empty(form, field)
    {
        // Get value of field that we are checking against
        var field_value = get_value(form, field);

        // Check if value is empty
        return (field_value === '' || field_value === null || field_value.length === 0);
    }

    /**
     * Check if field element contains string
     */
    function contains(form, field, value)
    {
        // Get value of field that we are checking against
        var field_value = get_value(form, field);

        // Will check subscring in string and whole array value in array (for select fields)
        if (field_value !== null && field_value.indexOf(value) > -1) {
            return true;
        }

        return false;
    }

    /**
     * Check if field element equals string
     */
    function equals(form, field, value)
    {
        // Get value of field that we are checking against
        var field_value = get_string_value(get_value(form, field));

        // Check if it equals given string
        if (field_value !== false && field_value === value) {
            return true;
        }

        return false;
    }

    /**
     * Check if field element is less than value
     */
    function less_than(form, field, value)
    {
        // Get value of field that we are checking against
        var field_value = get_string_value(get_value(form, field));

        // Check if value is less than given value
        if (field_value !== false && field_value < value) {
            return true;
        }

        return false;
    }

    /**
     * Check if field element is more than value
     */
    function more_than(form, field, value)
    {
        // Get value of field that we are checking against
        var field_value = get_string_value(get_value(form, field));

        // Check if value is less than given value
        if (field_value !== false && field_value > value) {
            return true;
        }

        return false;
    }

    /**
     * Check if field element is checked
     */
    function is_checked(form, field)
    {
        // In case of radio or checkbox
        if (field.is(':checkbox') || field.is(':radio')) {
            if (field.is(':checked')) {
                return true;
            }
        }

        // In case of other fields - make sure it's not empty
        else {
            if (!is_empty(form, field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get value depending on field type
     */
    function get_value(form, field)
    {
        // No field? This must be a condition dependant on checkbox or radio fields
        if (field.length === 0) {

            // Get beginning of potential field id
            var id = field.selector;
            id = id.replace('#', '');

            // Store values
            var values = [];

            // Iterate over all checkbox and radio elements in a given form
            form.find('input:radio, input:checkbox').each(function() {

                // Check if id of current element matches beginning of selector id and is checked
                if (jQuery(this).prop('id').indexOf(id) > -1 && jQuery(this).is(':checked')) {

                    // Also make sure it's not some other field which id begins with the same string
                    if (id + '_' + jQuery(this).val() === jQuery(this).prop('id')) {
                        values.push(jQuery(this).val());
                    }
                }
            });

            // Return values
            return values.length > 0 ? values : '';
        }

        // Field selected successfully - return value
        else {
            return (typeof field.val() === 'string' ? field.val().trim() : field.val());
        }
    }

    /**
     * Get string value from any value
     */
    function get_string_value(value)
    {
        // In case of string
        if (typeof value === 'string') {
            return value.trim();
        }

        // In case of array with single element
        if (value !== null && typeof value === 'object' && value.length === 1 && typeof value[0] === 'string') {
            return value[0].trim();
        }

        return false;
    }

    /**
     * Initialize frontend condition checks
     */
    jQuery('form:has(.wccf)').each(function() {

        // Get reference
        var form = jQuery(this);

        // Check conditions on page load
        check_conditions(form);

        // Check conditions on interaction with elements
        form.find('.wccf').each(function() {

            // Key up
            jQuery(this).keyup(function() {
                check_conditions(form);
            });

            // Value change
            jQuery(this).change(function() {
                check_conditions(form);
            });
        });
    });

});

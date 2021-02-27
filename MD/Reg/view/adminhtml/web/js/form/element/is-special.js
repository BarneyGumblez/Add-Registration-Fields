define([
    'jquery',
    'Magento_Ui/js/form/element/select',
    'uiRegistry'
], function ($, Select, uiRegistry) {
    'use strict';

    return Select.extend({
        defaults: {
            customName: '${ $.parentName }.${ $.index }_input'
        },
        selectOption: function (data, event, id) {
            if(event.target.value) {
                if(event.target.value === 'input') {
                    $('.md-reg-dynamic-options')[0].hidden = true;
                } else {
                    $('.md-reg-dynamic-options')[0].hidden = false;
                }
            }
        },
        checkOption: function () {
            uiRegistry.get("reg_fields_form.fields_form_data_source", function (element) {
                if(element.data.type == 'input') {
                    $('.md-reg-dynamic-options')[0].hidden = true;
                }
            });
        }

    });
});

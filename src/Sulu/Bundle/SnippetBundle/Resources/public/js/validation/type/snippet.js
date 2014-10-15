/*
 * This file is part of the Husky Validation.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 */

define([
    'type/default'
], function(Default) {

    'use strict';

    return function($el, options) {
        var defaults = {},

            subType = {
                setValue: function(value) {
                    var ids = [];
                    $.each(value, function (i, value) {
                        ids.push(value.uuid);
                    });
                    App.dom.data($el, 'preselected', ids);
                },

                getValue: function() {
                    return App.dom.data($el, 'snippet');
                },

                needsValidation: function() {
                    return false;
                },

                validate: function() {
                    return true;
                }
            };

        return new Default($el, defaults, options, 'snippet', subType);
    };
});

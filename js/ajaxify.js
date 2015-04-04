'use strict';

require(['jsSHA'], function (jsSHA) {
    var salt = 'djDzy4PCTEcLcmd6GAkykPthkkgmpJJ8H75WCPyJNXV4pKj2';

    // Handle forms submition
    //-----------------------

    $(document).ready(function () {
        $('form').on('submit', function (event) {
            // Stop submitting form
            event.preventDefault();
            event.stopPropagation();

            var form = this;

            // Load the module
            var moduleName = $(form).attr('data-module');
            require([moduleName], function (module) {
                submitForm(module, form);
            });
        });
    });

    var submitForm = function (module, form) {
        var method = $(form).attr('method');
        var url = $(form).attr('action');

        // Retreive data
        var values = extractedFieldValues(form, module);

        // FormData
        if (method.toLowerCase() == 'post') {
            var formData = new FormData();
            if (module.handleFormData) { // Module fills the formData
                module.handleFormData(formData, values);
            } else {
                formData.append('data', JSON.stringify(values));
            }
        } else {
            url += '&' + $.param(values);
        }

        // Send data
        var xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                     module.onSuccess(JSON.parse(xhr.response));
                } else {
                     module.onFail(xhr.status, xhr.response);
                }
            }
        };
        xhr.send(formData);
    };

    var extractedFieldValues = function (form, module) {
        var values = {};
        for (var x in form.elements) {
            var element = form.elements[x];
            if (element instanceof HTMLElement && element.name != '') {

                if (module.handleElement) { // Module handles the element
                    values[element.name] = module.handleElement(element);
                } else { // If module doesnt handle, hash passwords and encode others
                    if (element.type == 'password') {
                        var shaObj = new jsSHA(element.value + salt, 'TEXT');
                        values[element.name] = shaObj.getHash('SHA-512', 'HEX');
                    } else {
                        values[element.name] = encodeURIComponent(element.value);
                    }
                }
            }
        }
        return values;
    };

});

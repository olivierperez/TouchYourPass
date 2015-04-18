'use strict';

define('ajaxify', ['password'], function (password) {

    // Handle forms submition
    //-----------------------

    var ajaxifyForms = function () {
        $('form').on('submit', function (event) {
            // Stop submitting form
            event.preventDefault();
            event.stopPropagation();

            var form = this;

            // Load the module
            var moduleName = $(form).attr('data-module');
            require([moduleName], function (module) {
                module && submitForm(module, form) || console.log('Module not found', moduleName);
            });
        });
    };

    var submitForm = function (module, form) {
        // If module does not define handleSubmit
        // or if the return of handleSubmit is TRUE
        if (!module.handleSubmit || module.handleSubmit(form)) {
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
        }
    };

    var extractedFieldValues = function (form, module) {
        var values = {};
        for (var x in form.elements) {
            var element = form.elements[x];
            if (element instanceof HTMLElement && element.name != '') {

                if (module.handleElement) { // Module handles the element
                    var handleValue = module.handleElement(element);
                    if (handleValue !== undefined) {
                        values[element.name] = handleValue;
                    }
                } else { // If module doesnt handle, hash passwords and encode others
                    if (element.type == 'password') {
                        values[element.name] = password.hash(element.value);
                    } else {
                        values[element.name] = encodeURIComponent(element.value);
                    }
                }
            }
        }
        return values;
    };

    var ajaxifyLinks = function () {
        $('a.ajax').on('click', function (event) {
            // Stop submitting form
            event.preventDefault();
            event.stopPropagation();

            var link = $(this);
            var moduleName = link.attr('data-module');
            var url = link.attr('href');
            var method = link.attr('data-method') || 'GET';

            require([moduleName], function (module) {

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
                xhr.send(null);
            });
        });
    };

    var ajaxifyLink = function (element, onSuccess, onFail) {
        element.on('click', function (event) {
            // Stop submitting form
            event.preventDefault();
            event.stopPropagation();
            var a = $(this);

            var url = a.attr('href');
            var method = a.attr('data-method');

            // Send data
            var xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        onSuccess(JSON.parse(xhr.response));
                    } else {
                        onFail(xhr.status, xhr.response);
                    }
                }
            };
            xhr.send(null);
        });
    };

    return {
        ajaxifyLink: ajaxifyLink,
        ajaxifyLinks: ajaxifyLinks,
        ajaxifyForms: ajaxifyForms
    };
});

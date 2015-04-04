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

            var form = $(this);
            var method = form.attr('method');
            var url = form.attr('action');

            // Retreive data
            var data = {};
            for (var x in this.elements) {
                var element = this.elements[x];
                if (element instanceof HTMLElement && element.name != '') {
                    if (element.type == 'password') {
                        var shaObj = new jsSHA(element.value + salt, 'TEXT');
                        data[element.name] = shaObj.getHash('SHA-512', 'HEX');
                    } else {
                        data[element.name] = encodeURIComponent(element.value);
                    }
                }
            }

            if (method.toLowerCase() == 'post') {
                var formData = new FormData();
                formData.append('data', JSON.stringify(data));
            } else {
                url += '&' + $.param(data);
            }

            // FormData
            /**/

            // Send data
            var xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        require([form.attr('data-module')], function(module) {
                            module.onSuccess(JSON.parse(xhr.response));
                        });
                    } else {
                        require([form.attr('data-module')], function(module) {
                            module.onFail(xhr.status, xhr.response);
                        });

                    }
                }
            };
            xhr.send(formData);
        });
    });

});
'use strict';

define('key', ['gibberishaes', 'keystore'], function (GibberishAES, keystore) {

    var onSuccess = function (response) {
        var entry = keystore.decrypt(response.content);
        keystore.displayEntry(response.id, entry);

        $('#add-entry-form').trigger('reset');
    };

    var onFail = function (status, response) {
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        handleElement: function (element) {
            return element.value;
        },
        handleFormData: function (formData, values) {
            var passphrase = $('#passphrase').val();
            var json = JSON.stringify(values);
            var enc = GibberishAES.enc(json, passphrase);
            enc = enc.replace('\r\n', '').replace('\n', '');
            formData.append('data', enc);
        }
    }
});

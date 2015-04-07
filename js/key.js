'use strict';

define('key', ['sjcl', 'keystore'], function (sjcl, keystore) {

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
            var enc = sjcl.encrypt(passphrase, json);
            console.log('enc', enc);
            enc = enc.replace('\r\n', '').replace('\n', '');
            formData.append('data', enc);
        }
    }
});

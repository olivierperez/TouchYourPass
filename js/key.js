'use strict';

define('key', ['sjcl', 'keystore'], function (sjcl, keystore) {

    var onSuccess = function (response) {
        var entry = keystore.decrypt(response.content);
        keystore.addEntry(response.id, entry, true);

        // Reset all form fields but group
        $('#add-entry-form').trigger('reset');
        $('#add-entry-form').find('option[value=' + entry.group + ']').prop('selected', 'selected');
    };

    var onFail = function (status, response) {
    };

    var handleElement = function (element) {
        return element.value;
    };

    var handleFormData = function (formData, values) {
        var json = JSON.stringify(values);
        var enc = keystore.encrypt(json);
        console.log('enc', enc);
        enc = enc.replace('\r\n', '').replace('\n', '');
        formData.append('data', enc);
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        handleElement: handleElement,
        handleFormData: handleFormData
    }
});

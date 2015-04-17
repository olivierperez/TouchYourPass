'use strict';

define('password', ['jsSHA'], function (jsSHA) {

    var salt = 'djDzy4PCTEcLcmd6GAkykPthkkgmpJJ8H75WCPyJNXV4pKj2';

    var handleSubmit = function (form) {
        var hashed = hash(form.elements.passphrase.value);
        $('#hash').val(hashed);
        console.log('handleSubmit:form', form, hashed);
    };

    var hash = function(text) {
        var shaObj = new jsSHA(text + salt, 'TEXT');
        return shaObj.getHash('SHA-512', 'HEX');
    };

    return {
        handleSubmit: handleSubmit,
        hash: hash
    }
});

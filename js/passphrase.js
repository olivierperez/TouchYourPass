'use strict';

define('passphrase', ['jsSHA'], function (jsSHA) {

    var salt = 'djDzy4PCTEcLcmd6GAkykPthkkgmpJJ8H75WCPyJNXV4pKj2';

    var hash = function (text) {
        var shaObj = new jsSHA(text + salt, 'TEXT');
        return shaObj.getHash('SHA-512', 'HEX');
    };

    return {
        hash: hash
    }
});
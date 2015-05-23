'use strict';

define('passphrase', ['jsSHA'], function (jsSHA) {

    var massiveSalt = 'djDzy4PCTEcLcmd6GAkykPthkkgmpJJ8H75WCPyJNXV4pKj2';

    var hash = function (text, salt) {
        console.log('passphrase : text', text);
        console.log('passphrase : salt', salt);
        salt = salt || '';
        var shaObj = new jsSHA(salt + text + massiveSalt, 'TEXT');
        return shaObj.getHash('SHA-512', 'HEX');
    };

    return {
        hash: hash
    }
});
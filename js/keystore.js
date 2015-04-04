'use strict';

define('keystore', ['gibberishaes'], function (GibberishAES) {

    var onSuccess = function (response) {
        var passphraseField = $('#passphrase');

        cleanEntriesDisplay();

        var decryptionSuccess = false;
        for (var x in response) {
            var r = response[x];
            var encrypted = r.content;

            try {
                var entry = decrypt(encrypted);

                displayEntry(r.id, entry);
                passphraseField.closest('.form-group').addClass('hidden');
                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        if (decryptionSuccess) {
            $('#add-entry').fadeIn('slow');
        }

    };

    var onFail = function (status, response) {
        console.log('keystore-fail', response);
    };

    var decrypt = function (encrypted) {
        var passphrase = $('#passphrase').val();
        var decrypted = GibberishAES.dec(encrypted, passphrase);
        return JSON.parse(decrypted);
    };

    var cleanEntriesDisplay = function () {
        $('#entries').html('');
    };

    var displayEntry = function (id, entry) {
        var entries = $('#entries');
        var block = $('#entry-model').clone();

        var url = /^https?:\/\//.test(entry.url) ? entry.url : 'http://' + entry.url;

        block.find('h4').html(entry.login);
        block.find('a').attr('href', url).html(url);
        block.find('span').html(id);
        block.find('p').html(entry.passphrase);

        entries.append(block);
        block.attr('style', '');
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        displayEntry: displayEntry,
        decrypt: decrypt
    }
});

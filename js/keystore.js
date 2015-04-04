'use strict';

define('keystore', ['gibberishaes'], function (GibberishAES) {

    var onSuccess = function (response) {
        var passphraseField = $('#passphrase');
        console.log('keystore-success', response);

        cleanEntriesDisplay();

        for (var x in response) {
            var r = response[x];
            var passphrase = passphraseField.val();
            var encrypted = r.content;

            try {
                var decrypted = GibberishAES.dec(encrypted, passphrase);
                console.log('decrypted', decrypted);
                var entry = JSON.parse(decrypted);
                console.log('entry', entry);

                displayEntry(r.id, entry);
                passphraseField.closest('.form-group').addClass('hidden');
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }
    };

    var onFail = function (status, response) {
        console.log('keystore-fail', response);
    };

    var cleanEntriesDisplay = function () {
        $('#entries').html('');
    };

    var displayEntry = function (id, entry) {
        var entries = $('#entries');
        var block = $('#entry-model').clone();

        var url = /^https?:\/\//.test(entry.url) ? entry.url : 'http://' + entry.url;

        block.fadeIn();
        block.find('h4').html(entry.login);
        block.find('a').attr('href', url).html(url);
        block.find('span').html(id);
        block.find('p').html(entry.passphrase);

        entries.append(block);
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail
    }
});

'use strict';

define('keystore', ['gibberishaes', 'ajaxify'], function (GibberishAES, ajaxify) {

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
                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        if (decryptionSuccess || response.length === 0) {
            $('#add-entry').fadeIn('slow');
            passphraseField.closest('.form-group').addClass('hidden');
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
        var block = $('#entry-model').clone().attr('id', '');

        var url = /^https?:\/\//.test(entry.url) ? entry.url : 'http://' + entry.url;

        // Bind values
        block.find('h4.login').html(entry.login);
        block.find('a.url').attr('href', url).html(url);
        block.find('span.id').html(id);
        block.find('p.passphrase').html(entry.passphrase);

        // Bind delete button
        var a_delete = block.find('a.delete');
        a_delete.attr('href', a_delete.attr('href') + id);
        ajaxify.ajaxifyLink(a_delete, function (response) {
            a_delete.closest('.list-group-item').remove();
        }, function (status, response) {
        });

        // Add new block to HTML
        $('#entries').append(block);
        block.attr('style', null);
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        displayEntry: displayEntry,
        decrypt: decrypt
    }
});

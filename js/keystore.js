'use strict';

define('keystore', ['sjcl', 'ajaxify', 'zeroclipboard'], function (sjcl, ajaxify, zeroclipboard) {

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
        var decrypted = sjcl.decrypt(passphrase, encrypted);
        console.log('decrypted', 'decrypted');
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

        // Bind delete button
        var deleteLink = block.find('a.delete');
        deleteLink.attr('href', deleteLink.attr('href') + id);
        ajaxify.ajaxifyLink(deleteLink, function (response) {
            deleteLink.closest('.list-group-item').remove();
        }, function (status, response) {
            console.log('ajaxify failed', deleteLink, status, response);
        });

        // Bind copy button
        var copyBtn = block.find('button.copy');
        copyBtn.attr('data-clipboard-text', entry.passphrase);

        var zeroClient = new zeroclipboard(copyBtn);
        zeroClient.on({
            'ready': function () {
                console.log('zeroclipboard ready');
            },
            'error': function (event) {
                console.log('zeroclipboard error', event.name, event);
            }
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

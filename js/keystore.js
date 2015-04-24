'use strict';

define('keystore', ['sjcl', 'ajaxify', 'zeroclipboard'], function (sjcl, ajaxify, zeroclipboard) {

    var onSubmit = function () {
        var passphraseField = $('#passphrase');
        passphraseField.closest('.form-group').removeClass('has-error');
    };

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

    var handleElement = function (element) {
        return undefined;
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
        block.find('.title').html(entry.title);
        block.find('.login').html(entry.login);
        block.find('.url').attr('href', url).html(url);
        block.find('.id').html(id);

        // Bind delete button
        var deleteLink = block.find('.delete');
        deleteLink.attr('href', deleteLink.attr('href') + id);
        ajaxify.ajaxifyLink(deleteLink, function (response) {
            deleteLink.closest('.list-group-item').remove();
        }, function (status, response) {
            console.log('ajaxify failed', deleteLink, status, response);
        });

        // Bind copy button
        var copyBtn = block.find('.copy');
        copyBtn.attr('data-clipboard-text', entry.passphrase);

        var zeroClient = new zeroclipboard(copyBtn);
        zeroClient.on({
            'ready': function () {
                console.log('zeroclipboard ready');
            },
            'error': function (event) {
                console.log('zeroclipboard error', event);
                if (event.name === 'flash-deactivated') {
                    $('.copy').attr('disabled', 'disabled')
                        .parent().attr('title', 'no flash');
                }
            }
        });

        // Add new block to HTML
        $('#entries').append(block);
        block.attr('style', null);
    };

    var encrypt = function (text) {
        var passphrase = $('#passphrase').val();
        return sjcl.encrypt(passphrase, text);
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        onSubmit: onSubmit,
        handleElement: handleElement,
        displayEntry: displayEntry,
        decrypt: decrypt,
        encrypt: encrypt
    }
});

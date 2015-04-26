'use strict';

define('keystore', ['sjcl', 'ajaxify', 'zeroclipboard'], function (sjcl, ajaxify, zeroclipboard) {

    // Functions

    var onSubmit = function () {
        var passphraseField = $('#passphrase');
        passphraseField.closest('.form-group').removeClass('has-error');
    };

    var onSuccess = function (response) {
        var passphraseField = $('#passphrase');

        cleanGroupsDisplay();
        cleanEntriesDisplay();

        // Decrypt entries

        var entries = response.entries;
        var decryptionSuccess = false;
        for (var x in entries) {
            var r = entries[x];
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

        // Decrypt groups

        var groups = response.groups;
        for (var x in groups) {
            var r = groups[x];
            var encrypted = r.content;

            try {
                var group = decrypt(encrypted);

                displayGroup(r.id, group);
                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        if (decryptionSuccess || (response.entries.length === 0 && response.groups.length === 0)) {
            $('#add-entry').fadeIn('slow');
            $('#add-group').fadeIn('slow');
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

    var cleanGroupsDisplay = function () {
        $('#groups').find('.loaded').remove();
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

    var displayGroup = function (id, group) {
        var block = $('#group-model').clone().attr('id', '');

        // Bind values
        block.find('.title').html(group.title);
        block.find('.id').html(id);

        // Bind click
        block.find('.title').on('click', onGroupSelected);

        // Bind delete button
        var deleteLink = block.find('.delete');
        deleteLink.attr('href', deleteLink.attr('href') + id);
        ajaxify.ajaxifyLink(deleteLink, function () {
            deleteLink.closest('.btn-group').remove();
        }, function (status, response) {
            console.log('ajaxify failed', deleteLink, status, response);
        });

        // Add new block to HTML
        $('#default-group').before(block);
        block.attr('style', null);
    };

    var encrypt = function (text) {
        var passphrase = $('#passphrase').val();
        return sjcl.encrypt(passphrase, text);
    };

    var onGroupSelected = function () {
        $(this).closest('#groups').find('.active').removeClass('active');
        $(this).addClass('active');
    };

    // Load module

    $('#groups').contents().filter(function(){ return this.nodeType == 3; }).remove();
    $('#default-group').on('click', onGroupSelected);

    // Return functions

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        onSubmit: onSubmit,
        handleElement: handleElement,
        displayEntry: displayEntry,
        displayGroup: displayGroup,
        decrypt: decrypt,
        encrypt: encrypt
    }
});

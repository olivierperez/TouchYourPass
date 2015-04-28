'use strict';

define('keystore', ['sjcl', 'ajaxify', 'zeroclipboard'], function (sjcl, ajaxify, zeroclipboard) {

    // Variables

    var groups = {
        default: []
    };

    // Functions

    var onSubmit = function () {
        var passphraseField = $('#passphrase');
        passphraseField.closest('.form-group').removeClass('has-error');
    };

    var onSuccess = function (response) {
        var passphraseField = $('#passphrase');

        cleanGroupsDisplay();
        cleanEntriesDisplay();

        var decryptionSuccess = false;

        // Decrypt groups

        var gs = response.groups;
        for (var y in gs) {
            var g = gs[y];

            try {
                var group = decrypt(g.content);

                groups[g.id] = [];
                displayGroup(g.id, group);

                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        // Decrypt entries
        var entries = response.entries;
        for (var x in entries) {
            var e = entries[x];

            try {
                // Decrypt entry
                var entry = decrypt(e.content);

                // Add entry to right group
                var displayEntry = entry.group == 'default' || groups[entry.group] == undefined;
                addEntry(e.id, entry, displayEntry);

                // Display entry
                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        if (decryptionSuccess || (response.entries.length === 0 && response.groups.length === 0)) {
            $('#add-entry').fadeIn('slow');
            $('#add-group').fadeIn('slow');
            $('#entries').fadeIn('slow');
            $('#groups').fadeIn('slow');
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
        $('#group').html('<option value="">&nbsp;</option>');
        groups = {
            default: []
        };
    };

    var cleanEntriesDisplay = function () {
        $('#entries').html('');
    };

    var addEntry = function (id, entry, display) {
        var group = entry.group || 'default';
        if (groups[group] == undefined) {
            groups[group] = [];
        }
        groups[group][id] = entry;

        display && displayEntry(id, entry);
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
            delete groups[entry.group || 'default'][id];
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
        block.find('.title').attr('data-id', id);

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

        // Add group to select box
        var option = $(document.createElement('option'));
        option.attr('value', id);
        option.html(group.title);
        $('#group').append(option);
    };

    var encrypt = function (text) {
        var passphrase = $('#passphrase').val();
        return sjcl.encrypt(passphrase, text);
    };

    var onGroupSelected = function () {
        var $this = $(this);
        $this.closest('#groups').find('.active').removeClass('active');
        $this.addClass('active');

        var groupId = $this.attr('data-id');
        var group = groups[groupId];
        //console.log('group', groupId, group);

        $('#entries').fadeOut(200, function () {
            cleanEntriesDisplay();

            // Display entries of groups

            for (var x in group) {
                //console.log('group[x]', x, group[x]);
                var entry = group[x];
                displayEntry(x, entry);
            }

            // Preselect select box for group selection

            $('#group').find('option').each(function (index, element) {
                element = $(element);
                if (element.val() == groupId) {
                    element.prop('selected', true);
                } else {
                    element.removeAttr('selected');
                }
            });

            $('#entries').fadeIn(200);
        });

    };

    // Load module

    $('#groups').contents().filter(function () {
        return this.nodeType == 3;
    }).remove();
    $('#default-group').on('click', onGroupSelected);

    // Return functions

    return {
        onSuccess: onSuccess,
        onFail: onFail,
        onSubmit: onSubmit,
        handleElement: handleElement,
        addEntry: addEntry,
        displayGroup: displayGroup,
        decrypt: decrypt,
        encrypt: encrypt
    }
});

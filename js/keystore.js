'use strict';

define('keystore', ['sjcl', 'ajaxify', 'download'], function (sjcl, ajaxify, download) {

    // Variables

    var currentGroup = 'default';
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
                entry.group = entry.group == undefined || groups[entry.group] == undefined ? 'default' : entry.group;
                addEntry(e.id, entry);

                // Display entry
                decryptionSuccess = true;
            } catch (e) {
                console.error('Error found', e);
                passphraseField.closest('.form-group').addClass('has-error');
            }
        }

        // If decryption is OK or is there is nothing to decrypt, make everything appear
        if (decryptionSuccess || (response.entries.length === 0 && response.groups.length === 0)) {
            $('#' + currentGroup + '-group').trigger('click');
            $('#add-entry').fadeIn('slow');
            $('#add-group').fadeIn('slow');
            $('#entries').fadeIn('slow');
            $('#groups').fadeIn('slow');
            passphraseField.closest('.form-group').addClass('hidden');

            enableExport();
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
        $('#group').html('<option value="default">&nbsp;</option>');
        groups = {
            default: []
        };
    };

    var cleanEntriesDisplay = function () {
        $('#entries').html('');
    };

    var addEntry = function (id, entry) {
        var group = entry.group;
        groups[group][id] = entry;

        entry.group == currentGroup && displayEntry(id, entry);
    };

    var displayEntry = function (id, entry) {
        var block = $('#entry-model').clone().attr('id', '');

        var url = /^https?:\/\//.test(entry.url) ? entry.url : 'http://' + entry.url;

        // Bind values
        block.find('.title').html(entry.title);
        block.find('.login').html(entry.login);
        block.find('.url').attr('href', url).html(url);
        block.find('.passphrase').attr('value', entry.passphrase);
        block.find('.id').html(id);

        // Bind delete button
        var deleteLink = block.find('.delete');
        deleteLink.attr('href', deleteLink.attr('href') + id);
        ajaxify.ajaxifyLink(deleteLink, {
            success: function (response) {
                deleteLink.closest('.list-group-item').remove();
                delete groups[entry.group || 'default'][id];
            },
            fail: function (status, response) {
                console.log('ajaxify failed', deleteLink, status, response);
            }
        });

        // Bind copy button
        var copyBtn = block.find('.copy');
        copyBtn.on('click', function() {
            block.find('.passphrase').attr('type', 'text');
            block.find('.passphrase').select();
            document.execCommand("copy");
            block.find('.passphrase').attr('type', 'hidden');
        });

        // Add new block to HTML
        $('#entries').append(block);
        block.attr('style', null);
    };

    var displayGroup = function (id, group) {
        // Create an empty group
        groups[id] = [];

        // Copy the model
        var block = $('#group-model').clone().attr('id', '');

        // Bind values
        block.find('.title').html(group.title);
        block.find('.title').attr('data-id', id);
        block.find('.title').attr('id', id + '-group');

        // Bind click
        block.find('.title').on('click', onGroupSelected);

        // Bind delete button
        var deleteLink = block.find('.delete');
        deleteLink.attr('href', deleteLink.attr('href') + id);
        ajaxify.ajaxifyLink(deleteLink, {
            success: function () {
                deleteLink.closest('.btn-group').remove();
            },
            fail: function (status, response) {
                console.log('ajaxify failed', deleteLink, status, response);
            }
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
        var groupId = $this.attr('data-id');
        $this.closest('#groups').find('.active').removeClass('active');
        $this.addClass('active');

        showGroup(groupId);
    };

    var showGroup = function (groupId) {
        currentGroup = groupId;
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

    // Export keys

    var enableExport = function () {
        $('#export').show('fast');
        ajaxify.ajaxifyLink($('#export'), {
            submit: function () {

                // Build export object

                var exported = {};
                for (var g in groups) {
                    exported[g] = [];
                    for (var e in groups[g]) {
                        var entry = groups[g][e];
                        delete entry.group;
                        exported[g].push(entry);
                    }
                }

                // Convert to JSON

                var stringified = JSON.stringify(exported, function (key, value) {
                    if (value != undefined) {
                        return value;
                    }
                });

                // Download

                download(stringified, 'passwords.txt', 'text/plain');

                return false;
            }
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

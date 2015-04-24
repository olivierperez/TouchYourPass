'use strict';

define('login', function () {

    var onSubmit = function () {
        $('#name').closest('.form-group').removeClass('has-error');
        $('#passphrase').closest('.form-group').removeClass('has-error');
    };

    var onSuccess = function (response) {
        console.log(response);
        document.location = './keystore';
    };

    var onFail = function (status, response) {
        $('#name').closest('.form-group').addClass('has-error');
        $('#passphrase').closest('.form-group').addClass('has-error');
    };

    return {
        onSubmit: onSubmit,
        onSuccess: onSuccess,
        onFail: onFail
    }
});
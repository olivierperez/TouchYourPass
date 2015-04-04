'use strict';

define('login', function () {

    var onSuccess = function (response) {
        console.log(response);
        document.location = './index.php/' + response.id;
    };

    var onFail = function (status, response) {
        $('#name').closest('.form-group').addClass('has-error');
        $('#passphrase').closest('.form-group').addClass('has-error');
    };

    return {
        onSuccess: onSuccess,
        onFail: onFail
    }
});
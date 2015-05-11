{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('register', function () {

            var onSuccess = function (response) {
                showMessage('success', response.msg);
            };

            var onFail = function (status, response) {
                console.log(response);
                showMessage('danger', '<strong>' + status + ' ' + response.error + '</strong><br/>' + response.error_description);
            };

            var showMessage = function (type, message) {
                var msgBlock = $('#msg');
                msgBlock.html(message);
                msgBlock.removeClass('alert-success');
                msgBlock.removeClass('alert-danger');
                msgBlock.addClass('alert-' + type);
                msgBlock.fadeIn('fast');
            };

            return {
                onSuccess: onSuccess,
                onFail: onFail
            }
        });
    </script>
{/block}

{block name=main}
    <h1>{__('Title', 'Register')}</h1>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 well">
            <div>
                <form action="{$SERVER_URL}/api.php?s=user" method="POST" data-module="register">

                    <div id="msg" class="alert alert-danger" style="display:none">
                        ...
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="name" class="input-group-addon">{__('Generic', 'Name')}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                            <input type="password" class="form-control" id="passphrase" name="passphrase">
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Create')}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
{/block}
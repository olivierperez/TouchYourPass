{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('register', ['passphrase'], function (passphrase) {

            var form = undefined;

            var handleSubmit = function(f) {
                form = f;
                return true;
            };

            var handleElement = function(element) {
                console.log(element);
                return element.value;
            };

            var handleFormData = function (formData, values) {
                var data = {
                    name: values.name,
                    passphrase: passphrase.hash(values.passphrase, values.name)
                };
                formData.append('data', JSON.stringify(data));
            };

            var onSuccess = function (response) {
                $(form).parent().fadeOut('fast', function() {
                    showMessage('success', response.msg);
                });
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
                handleSubmit: handleSubmit,
                handleElement: handleElement,
                handleFormData: handleFormData,
                onSuccess: onSuccess,
                onFail: onFail
            }
        });
    </script>
{/block}

{block name=main}
    <h1><span class="glyphicon glyphicon-pencil"></span> {__('Title', 'Register')}</h1>
    <div class="row">
        <div id="msg" class="col-md-offset-3 col-md-6 alert alert-danger" style="display:none">
            ...
        </div>

        <div class="col-md-offset-3 col-md-6 well">
            <form action="{$SERVER_URL}/api.php?s=user" method="POST" data-module="register">

                <div class="form-group">
                    <div class="input-group">
                        <label for="name" class="input-group-addon">{__('Generic', 'Name')}</label>
                        <input type="text" class="form-control" id="name" name="name" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <label for="passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                        <input type="password" class="form-control" id="passphrase" name="passphrase">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{__('Generic', 'Create')}</button>
                </div>

            </form>
        </div>
    </div>
{/block}
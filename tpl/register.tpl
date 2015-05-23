{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('register', ['passphrase'], function (passphrase) {

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

            var handleElement = function(element) {
                console.log(element);
                return element.value;
            };

            var handleFormData = function (formData, values) {
                var data = {
                    name: values.name,
                    passphrase: passphrase.hash(values.passphrase, values.name)
                };
                console.log('data', data);
                console.log('values.passphrase', values.passphrase);
                console.log('values.name', values.name);
                formData.append('data', JSON.stringify(data));
            };

            return {
                onSuccess: onSuccess,
                onFail: onFail,
                handleElement: handleElement,
                handleFormData: handleFormData
            }
        });
    </script>
{/block}

{block name=main}
    <h1><span class="glyphicon glyphicon-pencil"></span> {__('Title', 'Register')}</h1>
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

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Create')}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
{/block}
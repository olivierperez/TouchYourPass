{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('install', function () {

            var onSuccess = function (response) {
                console.log('success', response);
                $('#result').html(response.msg)
                        .fadeIn('fast')
                        .addClass('alert-success')
                        .removeClass('alert-danger');
            };

            var onFail = function (status, response) {
                console.log('fail', response);
                $('#result').html(response.msg)
                        .fadeIn('fast')
                        .addClass('alert-danger')
                        .removeClass('alert-success');
            };

            var handleElement = function (element) {
                if (element.type == 'checkbox') {
                    return element.checked ? element.value : '';
                } else {
                    return element.value;
                }
            };

            return {
                onSuccess: onSuccess,
                onFail: onFail,
                handleElement: handleElement
            };
        });
    </script>
{/block}

{block name=main}
    <h1>{__('Title', 'Installation')}</h1>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="POST" data-module="install">

                <fieldset>
                    <legend>{__('Installation', 'Database')}</legend>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="dbConnectionString" class="input-group-addon">{__('Installation', 'DbConnectionString')}</label>
                            <input type="text" class="form-control" id="dbConnectionString" name="dbConnectionString" value="mysql:host=HOST;dbname=SCHEMA;port=3306" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="dbUser" class="input-group-addon">{__('Installation', 'DbUser')}</label>
                            <input type="text" class="form-control" id="dbUser" name="dbUser">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="dbPassword" class="input-group-addon">{__('Installation', 'DbPassword')}</label>
                            <input type="password" class="form-control" id="dbPassword" name="dbPassword">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>{__('Installation', 'Security')}</legend>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="salt" class="input-group-addon">{__('Installation', 'Salt')}</label>
                            <input type="text" class="form-control" id="salt" name="salt">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>{__('Installation', 'General')}</legend>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="allowRegister" class="input-group-addon">{__('Installation', 'AllowRegister')}</label>

                            <div class="form-control">
                                <input type="checkbox" id="allowRegister" name="allowRegister" checked>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="text-center form-group">
                    <button type="submit" class="btn btn-primary">{__('Installation', 'Install')}</button>
                </div>

                <div id="result" class="alert" style="display:none"></div>

            </form>
        </div>
    </div>
{/block}
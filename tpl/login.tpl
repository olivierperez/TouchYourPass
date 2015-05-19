{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1><span class="glyphicon glyphicon-log-in"></span> {__('Title', 'Log-in')}</h1>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 well">
            <div>
                <form action="{$SERVER_URL}/api.php?s=login" method="POST" data-module="login">

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
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Log-in')}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
{/block}
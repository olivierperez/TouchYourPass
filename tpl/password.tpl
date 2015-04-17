{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{__('Title', 'PasswordHashGeneration')}</h1>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 well">
            <div class="col-md-12">
                <form class="form-horizontal" action="{$SERVER_URL}/api.php?s=user" method="POST" data-module="password">

                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> {__('PasswordHash', 'DontUseItFromComputerOfSomeoneElse')}
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                            <input type="password" class="form-control" id="passphrase" name="passphrase">
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Generate')}</button>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="hash" class="input-group-addon">{__('Generic', 'Hash')}</label>
                            <input type="text" class="form-control" id="hash" name="hash" readonly>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
{/block}
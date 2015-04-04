{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{__('Title', 'Keystore')}</h1>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 well">
            <div class="form-group">
                <div class="input-group">
                    <label for="passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                    <input type="password" class="form-control" id="passphrase" name="passphrase">
                </div>
            </div>

            <form class="form-horizontal" action="{$SERVER_URL}/api.php?s=entry" method="GET" data-module="keystore">
                <input type="hidden" id="user" name="user" value="{$user->id}">

                <div class="text-center">
                    <button type="submit" class="btn btn-default">{__('Entry', 'Load entries')}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div id="entries" class="list-group">
            </div>

            <!-- Add an entry -->
            <div id="add-entry" class="well row" style="display:none">
                <div class="col-md-12">
                    <form id="add-entry-form" class="form-horizontal" action="{$SERVER_URL}/api.php?s=entry" method="POST"
                          data-module="key">

                        <div class="form-group">
                            <div class="input-group">
                                <label for="login" class="input-group-addon">{__('Generic', 'Login')}</label>
                                <input type="text" class="form-control" id="login" name="login">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <label for="url" class="input-group-addon">{__('Generic', 'Web site')}</label>
                                <input type="text" class="form-control" id="url" name="url">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <label for="add_passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                                <input type="password" class="form-control" id="add_passphrase" name="passphrase">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{__('Generic', 'Add')}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Model -->
            <div id="entry-model" class="list-group-item row" style="display:none">
                <h4 class="list-group-item-heading col-md-5">...</h4>

                <div class="col-md-6">
                    <a href="..." target="_blank">...</a>
                </div>
                <span class="badge col-md-1">0</span>

                <p class="list-group-item-text col-md-12">...</p>
            </div>
        </div>
    </div>
{/block}
{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{__('Title', 'Keystore')}</h1>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 well">
            <form action="{$SERVER_URL}/api.php?s=entry" method="get" data-module="keystore">
                <div class="form-group">
                    <div class="input-group">
                        <label for="passphrase" class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                        <input type="password" class="form-control" id="passphrase" name="passphrase" autofocus>
                    </div>
                </div>

                <div class="text-center">
                    <input type="submit" class="ajax btn btn-default" value="{__('Entry', 'Load entries')}"/>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <!-- Groups list -->
            <div id="groups" style="display:none">
                <button id="default-group" type="button" class="btn btn-default active" data-id="default">{__('Group', 'Default')}</button>
            </div>

            <!-- Add an group -->
            <div id="add-group" class="well" style="display:none">
                <form id="add-group-form" action="{$SERVER_URL}/api.php?s=group"
                      method="POST" data-module="group">

                    <div class="form-group">
                        <div class="input-group">
                            <label for="group-title" class="input-group-addon">{__('Generic', 'Group')}</label>
                            <input type="text" class="form-control" id="group-title" name="title">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Add')}</button>
                    </div>
                </form>
            </div>

            <!-- Group model -->
            <div id="group-model" class="btn-group loaded" style="display:none">
                <button type="button" class="btn btn-default title">...</button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{$SERVER_URL}/api.php?s=group&id=" class="delete" data-method="delete"
                           title="{__('Generic', 'Delete')}">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            {__('Generic', 'Delete')}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <!-- Entries list -->
            <div id="entries" class="list-group" style="display:none"></div>

            <!-- Add an entry -->
            <div id="add-entry" class="well" style="display:none">
                <form id="add-entry-form" action="{$SERVER_URL}/api.php?s=entry"
                      method="POST" data-module="key">

                    <div class="form-group">
                        <div class="input-group">
                            <label for="title" class="input-group-addon">{__('Generic', 'Title')}</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="group" class="input-group-addon">{__('Generic', 'Group')}</label>
                            <select class="form-control" id="group" name="group">
                            </select>
                        </div>
                    </div>

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
                            <label for="add_passphrase"
                                   class="input-group-addon">{__('Generic', 'Passphrase')}</label>
                            <input type="password" class="form-control" id="add_passphrase" name="passphrase">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{__('Generic', 'Add')}</button>
                    </div>
                </form>
            </div>

            <!-- Entry model -->
            <div id="entry-model" class="list-group-item entry" style="display:none">
                <div class="row">
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-default copy" title="{__('Generic', 'Copy')}">
                            <span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
                            <span class="sr-only">Copy</span>
                        </button>
                    </div>

                    <div class="col-md-5">
                        <div class="title">...</div>
                        <div class="login">...</div>
                    </div>

                    <div class="col-md-5">
                        <a href="..." class="url" target="_blank">...</a>
                    </div>

                    <div class="col-md-1">
                        <span class="badge pull-right id">0</span>

                        <a href="{$SERVER_URL}/api.php?s=entry&id=" class="pull-right delete" data-method="delete"
                           title="{__('Generic', 'Delete')}">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            <span class="sr-only">Delete</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}
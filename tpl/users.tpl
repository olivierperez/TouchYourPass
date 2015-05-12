{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('users', function () {

            var onSuccess = function (response) {
                console.log('success', response);
                for (var x in response) {
                    displayUser(response[x]);
                }
            };

            var onFail = function (status, response) {
                console.log('fail', response);
            };

            var displayUser = function (user) {
                var trModel = $('#user-model');
                var tr = trModel.clone().attr('id', '');
                trModel.before(tr);

                tr.find('.id').html(user.id);
                tr.find('.name').html(user.name);

                var activateBtn = tr.find('.activated').find('.no');
                var deactivateBtn = tr.find('.activated').find('.yes');
                activateBtn.attr('href', activateBtn.attr('href') + user.id);
                deactivateBtn.attr('href', activateBtn.attr('href') + user.id);

                var refreshActivateButtons = function() {
                    if (user.active == 1) {
                        activateBtn.hide();
                        deactivateBtn.show();
                    } else {
                        deactivateBtn.hide();
                        activateBtn.show();
                    }
                };

                var toggleActiveUser = function (ev) {
                    user.active ^= 1;
                    refreshActivateButtons();
                    console.log('onClick', ev, user);
                    return false;
                };

                refreshActivateButtons();
                activateBtn.on('click', toggleActiveUser);
                deactivateBtn.on('click', toggleActiveUser);

                tr.fadeIn('fast');
            };

            return {
                onSuccess: onSuccess,
                onFail: onFail
            };
        });
    </script>
{/block}

{block name=main}
    <h1>{__('Title', 'Users')}</h1>
    <form action="{$SERVER_URL}/api.php?s=user" method="GET" data-module="users">
        <input type="submit" value="{__('Generic', 'Load')}" class="btn btn-default"/>
    </form>
    <div class="panel panel-default">
        <table class="table table-striped table-bordered">
            <tr>
                <th width="50px">{__('Generic', 'id')}</th>
                <th width="50px">{__('Generic', 'Active')}</th>
                <th>{__('Generic', 'Name')}</th>
            </tr>
            <tr id="user-model" style="display:none">
                <td class="id">id</td>
                <td class="activated">
                    <a href="{$SERVER_URL}/api.php?s=user&id=" data-method="UPDATE" class="glyphicon glyphicon-ok yes" aria-hidden="true"></a>
                    <a href="{$SERVER_URL}/api.php?s=user&id=" data-method="UPDATE" class="glyphicon glyphicon-ban-circle no" aria-hidden="true"></a>
                </td>
                <td class="name">name</td>
            </tr>
        </table>
    </div>
{/block}
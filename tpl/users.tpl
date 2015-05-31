{extends file='page.tpl'}

{block name=head}
    <script type="text/javascript">
        define('users', ['ajaxify'], function (ajaxify) {

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
                // Clone the model
                var trModel = $('#user-model');
                var tr = trModel.clone().attr('id', '');
                trModel.before(tr);

                // Apply attributes
                tr.find('.id').html(user.id);
                tr.find('.name').html(user.name);

                // Apply attributes on links
                var activateBtn = tr.find('.activated').find('.no');
                var deactivateBtn = tr.find('.activated').find('.yes');

                // Hanlde clicks on buttons
                var refreshActivateButtons = function () {
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
//                    console.log('onClick', ev, ev.target, user);

                    var target = $(ev.target);

                    var method = target.attr('data-method') || 'POST';
                    var url = target.attr('href');
                    var formData = new FormData();
                    formData.append('data', JSON.stringify(user));

                    // Send data
                    var xhr = new XMLHttpRequest();
                    xhr.open(method, url, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                user = JSON.parse(xhr.response);
                                refreshActivateButtons();
                            } else {
                                console.log('fail', xhr.status, JSON.parse(xhr.response))
                            }
                        }
                    };
                    xhr.send(formData);

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
    <form action="{$SERVER_URL}/api.php?s=user" method="GET" data-module="users" data-module-auto="auto">
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
                    <a href="{$SERVER_URL}/api.php?s=user" data-method="POST" class="glyphicon glyphicon-ok yes" aria-hidden="true"></a>
                    <a href="{$SERVER_URL}/api.php?s=user" data-method="POST" class="glyphicon glyphicon-ban-circle no" aria-hidden="true"></a>
                </td>
                <td class="name">name</td>
            </tr>
        </table>
    </div>
{/block}
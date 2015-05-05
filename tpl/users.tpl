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
                tr.find('.activated').html(user.active ? '{__('Generic', 'Yes')}' : '{__('Generic', 'No')}');

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
    <form action="{$SERVER_URL}/api.php?s=user" method="get" data-module="users">
        <input type="submit" value="{__('Generic', 'Load')}"/>
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
                <td class="activated">activated</td>
                <td class="name">name</td>
            </tr>
        </table>
    </div>
{/block}
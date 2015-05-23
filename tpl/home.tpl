{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{$APPLICATION_NAME}</h1>
    <div class="row">
        <div class="col-md-4">
            <h2><span class="glyphicon glyphicon-sunglasses"></span> {__('Home', 'Passphrases')}</h2>
            {__('Home', 'PassphrasesExplanation')}
        </div>
        <div class="col-md-4">
            <h2><span class="glyphicon glyphicon-alert"></span> {__('Home', 'IsItSafe')}</h2>
            {__('Home', 'IsItSafeExplanation')}
        </div>
        <div class="col-md-4">
            <h2><span class="glyphicon glyphicon-eye-open"></span> {__('Home', 'OpenSourceProject')}</h2>
            {__('Home', 'OpenSourceProjectExplanation')}
        </div>
    </div>
    {if !$loggedIn}
        <div class="row">
            <div class="col-md-6">
                <div class="well well-sm">
                    <h2><span class="glyphicon glyphicon-pencil"></span> {__('Title', 'Register')}</h2>
                    {if $ALLOW_REGISTER}
                        {__f('Home', 'RegisterExplanation', 'register'|page)}
                    {else}
                        {__('Home', 'RegisterNotAllowedExplanation')}
                    {/if}
                </div>
            </div>
            <div class="col-md-6">
                <div class="well well-sm">
                    <h2><span class="glyphicon glyphicon-log-in"></span> {__('Title', 'Log-in')}</h2>
                    {__f('Home', 'LogInExplanation', 'login'|page)}
                </div>
            </div>
        </div>
    {/if}
{/block}
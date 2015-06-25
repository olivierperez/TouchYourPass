{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{$APPLICATION_NAME}</h1>
    <div class="row">
        <div class="col-md-12">
            <h2><span class="glyphicon glyphicon-briefcase"></span> {__('Home', 'Presentation')}</h2>
            {__('Home', 'TouchYourPassExplanation')}
        </div>
    </div>
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

    <div class="row">
        {if !$loggedIn}
            {if $ALLOW_REGISTER}
                <a href="{'login'|page}" class="btn btn-primary col-md-4 col-md-offset-1">
                    <h2><span class="glyphicon glyphicon-pencil"></span> {__('Title', 'Register')}</h2>
                </a>
            {else}
                <a href="" disabled class="btn btn-primary col-md-4 col-md-offset-1">
                    <h2><span class="glyphicon glyphicon-pencil"></span> {__('Title', 'Register')}</h2>
                    {__('Home', 'RegisterNotAllowedExplanation')}
                </a>
            {/if}
            <a href="{'login'|page}" class="btn btn-primary col-md-4 col-md-offset-2">
                <h2><span class="glyphicon glyphicon-log-in"></span> {__('Title', 'Log-in')}</h2>
            </a>
        {else}
            <a href="{'keystore'|page}" class="btn btn-primary col-md-6 col-md-offset-3">
                    <h2><span class="glyphicon glyphicon-briefcase"></span> {__('Title', 'Keystore')}</h2>
            </a>
        {/if}
    </div>
{/block}
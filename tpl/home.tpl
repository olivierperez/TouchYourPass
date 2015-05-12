{extends file='page.tpl'}

{block name=head}
{/block}

{block name=main}
    <h1>{$APPLICATION_NAME}</h1>
    <div class="row">
        <div class="col-md-4">
            <h2>{__('Home', 'Passphrases')}</h2>
            {__('Home', 'PassphrasesExplanation')}
        </div>
        <div class="col-md-4">
            <h2>{__('Home', 'IsItSafe')}</h2>
            {__('Home', 'IsItSafeExplanation')}
        </div>
        <div class="col-md-4">
            <h2>{__('Home', 'OpenSourceProject')}</h2>
            {__('Home', 'OpenSourceProjectExplanation')}
        </div>
    </div>
{/block}
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>{$APPLICATION_NAME|html}</title>
    <link rel="icon" href="/favicon.ico">

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Style -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/typ.css">

    <!-- Bootstrap JS -->
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="{'/bower_components/requirejs/require.js'|resource}"></script>
    <script src="{'/js/ajaxify.js'|resource}"></script>
    <script type="text/javascript">
        require.config({
            paths: {
                sjcl: "{'/bower_components/sjcl/sjcl'|resource}",
                jsSHA: "{'/bower_components/jsSHA/src/sha'|resource}",
                zeroclipboard: "{'/bower_components/zeroclipboard/dist/ZeroClipboard'|resource}",
                keystore: "{'/js/keystore'|resource}",
                key: "{'/js/key'|resource}",
                group: "{'/js/group'|resource}",
                ajaxify: "{'/js/ajaxify'|resource}",
                passphrase: "{'/js/passphrase'|resource}"
            }
        });

        require(['ajaxify'], function (ajaxify) {
            $(document).ready(function () {
                ajaxify.ajaxifyForms();
                ajaxify.ajaxifyLinks();
            });
        });
    </script>
    {block name=head}{/block}
<body>
{$hideNavBar = $hideNavBar|default:false}
{$currentPage = $currentPage|default:''}
{if !$hideNavBar}
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{$SERVER_URL}">{$APPLICATION_NAME|html}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                {if $loggedIn}
                    <li>
                        <a href="{'logout'|page}">
                            <span class="glyphicon glyphicon-log-out"></span>
                            {__('Title', 'Logout')}
                        </a>
                    </li>
                {else}
                    {if $ALLOW_REGISTER}
                        <li class="{cond if=$currentPage=='register' then='active'}">
                            <a href="{'register'|page}">
                                <span class="glyphicon glyphicon-pencil"></span>
                                {__('Title', 'Register')}
                            </a>
                        </li>
                    {/if}
                    <li class="{cond if=$currentPage=='login' then='active'}">
                        <a href="{'login'|page}">
                            <span class="glyphicon glyphicon-log-in"></span>
                            {__('Title', 'Log-in')}
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
{/if}

<main class="container" role="main">


    {block name=main}{/block}

    <hr/>
    <footer class="text-right">© <a href="https://github.com/olivierperez/">Olivier Perez</a> - 2015</footer>

</main>

</body>
</html>
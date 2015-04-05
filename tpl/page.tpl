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
                gibberishaes: "{'/bower_components/gibberish-aes/dist/gibberish-aes-1.0.0'|resource}",
                jsSHA: "{'/bower_components/jsSHA/src/sha'|resource}",
                keystore: "{'/js/keystore'|resource}",
                key: "{'/js/key'|resource}",
                login: "{'/js/login'|resource}",
                ajaxify: "{'/js/ajaxify'|resource}"
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
            <span class="navbar-brand">{$APPLICATION_NAME|html}</span>
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>

<main class="container" role="main">


    {block name=main}{/block}

    <hr/>
    <footer class="text-right">© Olivier Perez - 2015</footer>

</main>

</body>
</html>
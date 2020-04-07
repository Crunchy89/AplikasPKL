<!DOCTYPE html>
<!-- saved from url=(0119)https://pixinvent.com/materialize-material-design-admin-template/html/ltr/vertical-modern-menu-template/user-login.html -->
<html class="loading" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="ThemeSelect">
    <title>User Login</title>
    <link rel="apple-touch-icon" href="<?= base_url() ?>assets/img/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon-32x32.png">
    <link href="<?= base_url() ?>assets/vendor/icon" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/login.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/custom.css">
    <script src="<?= base_url() ?>assets/vendor/vendors.min.js"></script>
    <script>
        $(document).ready(function() {
            let page = window.location.hash.substr(1);
            if (page == '') page = 'login';
            $('#login').load(`<?= site_url() ?>/auth/${page}`);
        })
    </script>
</head>

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 1-column login-bg blank-page blank-page" data-col="1-column">>
    <?= $view ?>
    <script src="<?= base_url() ?>assets/vendor/plugins.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/search.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/custom-script.min.js"></script>
</body>

</html>
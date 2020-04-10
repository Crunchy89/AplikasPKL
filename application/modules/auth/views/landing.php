<!DOCTYPE html>
<!-- saved from url=(0119)https://pixinvent.com/materialize-material-design-admin-template/html/ltr/vertical-modern-menu-template/user-login.html -->
<html class="loading" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="ThemeSelect">
    <title>Reset Password</title>
    <link rel="apple-touch-icon" href="<?= base_url() ?>assets/img/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/login.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/custom.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/sweetalert.css">
    <script src="<?= base_url() ?>assets/vendor/vendors.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/extra-components-sweetalert.min.js"></script>
</head>

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 1-column login-bg blank-page blank-page" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form id="login" class="login-form">
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4">Reset Password</h5>
                                </div>
                            </div>
                            <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
                            <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input id="password" type="password" name="password">
                                    <label for="password" class="center-align">New Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input id="password2" type="password" name="password2">
                                    <label for="password2" class="center-align">Confirm Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12 mb-1">Reset Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#login').submit(function(e) {
                e.preventDefault();
                const pass = $('#password').val();
                const pass2 = $('#password2').val();
                if (pass != '' && pass2 != '') {
                    $.ajax({
                        url: `<?= site_url('auth/reset') ?>`,
                        type: 'post',
                        dataType: 'json',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        async: false,
                        success: result => {
                            if (result.status == true) {
                                swal({
                                    title: result.pesan,
                                    icon: 'success',
                                    timer: 2000,
                                    buttons: false
                                })
                                setTimeout(function() {
                                    window.location.href = '<?= site_url('auth') ?>'
                                }, 2000);
                            } else {
                                swal({
                                    title: result.pesan,
                                    icon: 'error',
                                    timer: 2000,
                                    buttons: false
                                })

                            }
                        }
                    })
                }
                if (pass != pass2) {
                    swal({
                        title: 'Password tidak sama',
                        icon: 'error',
                        timer: 2000,
                        buttons: false
                    })
                }
                if (pass2 == '') {
                    swal({
                        title: 'Confirm Password tidak boleh kosong',
                        icon: 'error',
                        timer: 2000,
                        buttons: false
                    })
                }
                if (pass == '') {
                    swal({
                        title: 'Kolom Password tidak boleh kosong',
                        icon: 'error',
                        timer: 2000,
                        buttons: false
                    })
                }

            })
        });
    </script>
    <script src="<?= base_url() ?>assets/vendor/plugins.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/search.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/custom-script.min.js"></script>
</body>

</html>
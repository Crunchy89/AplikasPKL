<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/toastr/toastr.min.css">
    <script src="<?= base_url() ?>assets/bower_components/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/toastr/toastr.min.js"></script>
    <style type="text/css">
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #fff;
        }

        .preloader .loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font: 14px arial;
        }
    </style>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".preloader").fadeOut();
            }, 1000);
            var page = window.location.hash.substr(1);
            if (page == "") page = "admin/dashboard";
            $('#show_data').load('<?= site_url() ?>' + '/' + page);
        });
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url() ?>assets/img/loader.gif" width="300">
            <p class="text-center">Harap Tunggu</p>
        </div>
    </div>
    <?= $this->session->flashdata('pesan') ?>
    <div class="wrapper">

        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini LOGO"><img class="user-image" src="<?= base_url() ?>assets/img/user.png" width="40px" height="40px" alt="Logo"></span>
                <span class="logo-lg LOGO"><img class="user-image" src="<?= base_url() ?>assets/img/user.png" width="40px" height="40px" alt="Logo"></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= base_url() ?>assets/img/user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= $this->session->userdata('username') ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?= base_url() ?>assets/img/user.png" class="img-circle" alt="User Image">
                                    <p>
                                        Alexander Pierce - Web Developer
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= site_url('admin/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= base_url() ?>assets/img/user.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $this->session->userdata('username') ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree" id="menu">
                    <li class="header">MAIN NAVIGATION</li>
                </ul>
            </section>
        </aside>
        <div class="content-wrapper" id=show_data>
            <?= $view ?>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; <?= date('Y') ?> Ferdy Barliansyah R.
        </footer>
    </div>
    <script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            $.ajax({
                url: '<?= site_url('admin/menu') ?>',
                type: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                async: true,
                success: data => {
                    let menu = ''
                    for (i = 0; i < data.length; i++) {
                        let sub = '';
                        for (j = 0; j < data[i].submenu.length; j++) {
                            submenu = `<li data-url="${data[i].submenu[j].url}" class="submenu"><a href="#${data[i].submenu[j].url}"><i class="${data[i].submenu[j].icon}"></i>${data[i].submenu[j].title}</a></li>`;
                            sub += submenu;
                        }
                        menu += `<li class="treeview">
                            <a href="#">
                            <i class="${data[i].icon}"></i>
                            <span>${data[i].title}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu submenu">
                            ${sub}</ul>
                            </li>`;
                    }
                    $('#menu').html(menu);
                    $('#menu').on('click', 'li', function() {
                        $('li').removeClass('active');
                        $(this).addClass('active');
                    })
                    $('.submenu').on('click', 'li', function() {
                        link = $(this).data('url');
                        $.ajax({
                            url: '<?= site_url() ?>' + '/' + link,
                            type: 'get',
                            success: data => {
                                $('#show_data').html(data);
                            },
                            error: status => {
                                let html = `<section class="content">
                                    <div class = "error-page" >
                                    <h4 class = "headline text-yellow" >${status.status}</h4 >
                                    <div class = "error-content">
                                    <h1><i class="fa fa-warning text-yellow" ></i>${status.statusText}</h1>
                                    </div>
                                    </div>
                                    </section>`;
                                $('#show_data').html(html);
                            }
                        })
                    });
                }
            });
        });
    </script>
</body>

</html>
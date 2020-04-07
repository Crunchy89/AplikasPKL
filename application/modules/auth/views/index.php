<div class="row">
    <div class="col s12">
        <div class="container">
            <div id="login-page" class="row">
                <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                    <form id="login" class="login-form">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#login').on('click', 'a', function() {
            let load = $(this).attr('href');
            if (load == "#forgot") {
                $('#login').load('<?= site_url('auth/forgot') ?>')
            } else {
                $('#login').load('<?= site_url('auth/login') ?>')
            }
        });
        $('#login').submit(function(e) {
            e.preventDefault();
            let user = $('#username').val();
            let pass = $('#password').val();
            let email = $('#email').val();
            if (user == '') {
                $('[for="username"]').html('Field Username tidak boleh kosong');
            } else {
                $('[for="username"]').html('Username');
            }
            if (pass == '') {
                $('[for="password"]').html('Field Password tidak boleh kosong');
            } else {
                $('[for="password"]').html('Password');
            }
            if (email == '') {
                $('[for="email"]').html('Field Email tidak boleh kosong');
            } else {
                $('[for="email"]').html('Email');
            }
            $.ajax({
                url: `<?= site_url('auth/aksi') ?>`,
                type: 'post',
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: false,
                success: result => {
                    console.log(result);
                    if (result.username) {
                        $('[for="username"]').html(result.username);
                    }
                    if (result.password) {
                        $('[for="password"]').html(result.password);
                    }
                }
            })
        })
    });
</script>
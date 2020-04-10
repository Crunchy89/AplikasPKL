<section class="content-header">
    <h1>
        Profile
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">My Profile</h3>
                </div>
                <div class="box-body" id="sarjana">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form-horizontal" id="profile">
                            <input type="hidden" name="aksi" id="aksi" value="edit">
                            <input type="hidden" name="gambarLama" id="gambarLama">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="nik" class="col-sm-2 control-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="nik" id="nik" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="col-sm-2 control-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="nama" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3" disabled></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp" class="col-sm-2 control-label">No Telepon</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="no_hp" id="no_hp" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="web" class="col-sm-2 control-label">Website</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="web" id="web" disabled>
                                </div>
                            </div>
                            <div id="form">
                                <div class="form-group">
                                    <label for="web" class="col-sm-2 control-label">Foto</label>
                                    <div class="col-sm-10">
                                        <label for="gambar" class="col-sm-4" id="reset"></label>
                                        <input type="file" class="custom-file-input" accept="image/*" onchange="loadFile(event)" id="gambar" name="gambar">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="button">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-primary edit">Edit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {

        show_data();
        $('#form').hide();

        function show_data() {
            $.ajax({
                url: '<?= site_url('profile/getData') ?>',
                type: 'post',
                dataType: 'json',
                success: data => {
                    $('#id').val(data.id_civitas);
                    $('#nik').val(data.nik);
                    $('#nama').val(data.nm_lengkap);
                    $('.profile-username').html(data.nm_lengkap);
                    $('#alamat').val(data.alamat);
                    $('.text-muted').html(data.alamat);
                    $('#no_hp').val(data.tlp);
                    $('#email').val(data.email);
                    $('#web').val(data.website);
                    $('#gambarLama').val(data.foto);
                    $('#sarjana').html(`
                    <img src="<?= base_url() ?>assets/img/profile/${data.foto}" alt="User profile picture" width="100%">
                    `);
                    $('#reset').html(`
                    <img src="<?= base_url() ?>assets/img/profile/${data.foto}" id="output" alt="User profile picture" width="150px">
                    `);
                }
            })
        }
        $('#profile').on('click', '.edit', function() {
            foto = $('#gambarLama').val();
            $('#profile').find('input, textarea').removeAttr('disabled');
            $('#form').fadeIn();
            $('#button').html(`
        <div class="col-sm-offset-2 col-sm-10">
        <button type="button" class="btn btn-danger cancel">Cancel</button>
        <button type="submit" class="btn btn-success simpan">Simpan</button>
        </div>
        `);
        })
        $('#profile').on('click', '.cancel', function() {
            show_data()
            $('#profile').find('input,textarea').attr('disabled', 'disabled');
            $('#form').hide();
            $('#button').html(`
        <div class="col-sm-offset-2 col-sm-10">
        <button type="button" class="btn btn-primary edit">Edit</button>
        </div>
        `);
        })
        $('#profile').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url('civitas/aksi') ?>',
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false,
                success: result => {
                    show_data();
                    $('#profile').find('input,textarea').attr('disabled', 'disabled');
                    $('#form').hide();
                    $('#button').html(`
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary edit">Edit</button>
                    </div>
                    `);
                    if (result.status == true) {
                        toastr["success"](result.pesan);
                    } else {
                        toastr["error"](result.pesan);
                    }
                }
            })
        })

    })
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
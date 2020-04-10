<section class="content-header">
    <h1>
        Pendidikan Civitas
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Pendidikan</h3>
                </div>
                <div class="box-body" id="sarjana">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form-horizontal" id="pendidikan">
                            <div id="form">
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

        function show_data() {
            $.ajax({
                url: '<?= site_url('pendidikan/getData') ?>',
                type: 'post',
                dataType: 'json',
                success: data => {
                    arr = [];
                    val = [];
                    ijasah = [];
                    arr[0] = data.s1;
                    val[0] = data.s1;
                    arr[1] = data.s2;
                    val[1] = data.s2;
                    arr[2] = data.s3;
                    val[2] = data.s3;
                    ijasah[0] = data.ijasah_s1;
                    ijasah[1] = data.ijasah_s2;
                    ijasah[2] = data.ijasah_s3;
                    page = '';
                    form = '';
                    file = '';
                    for (i = 0; i < 3; i++) {
                        if (val[i] == null) {
                            val[i] = '';
                        }
                        if (ijasah[i] == null || ijasah[i] == '') {
                            file = `
                            <div class="form-group">
                                <label for="ijasahs${i+1}" class="col-sm-2 control-label">Ijasah S${i+1}</label>
                                <div class="col-sm-10">
                                    <a href="#" class="btn btn-info" disabled><i class="fa fa-fw fa-eye-slash"></i> Data Belum Ada</a>
                                </div>
                            </div>
                            `;
                        } else {
                            file = `
                            <div class="form-group">
                                <label for="ijasahs${i+1}" class="col-sm-2 control-label">Ijasah S${i+1}</label>
                                <div class="col-sm-10">
                                    <a href="<?= base_url() ?>/assets/img/ijasah/${ijasah[i]}" class="btn btn-info" target="_BLANK"><i class="fa fa-fw fa-eye"></i> Lihat Ijasah</a>
                                </div>
                            </div>
                            `;
                        }
                        if (arr[i] == null || arr[i] == '') {
                            arr[i] = 'Belum ada Data';
                        }
                        form += `
                        <div class="form-group">
                                <input type="hidden" name="oldIjasah_s${i+1}" value="${ijasah[i]}">
                                <label for="s${i+1}" class="col-sm-2 control-label">Lulus S${i+1}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="s${i+1}" id="s${i+1}" placeholder="Nama Kampus" value="${val[i]}" disabled>
                                </div>
                        </div>
                        <div id="file${i+1}">
                        ${file}
                        </div>
                        `;
                        page += `
                        <strong><i class="fa fa-book margin-r-5"></i> S${i+1}</strong>
                        <p class="text-muted">
                        ${arr[i]}
                        </p>
                        <hr>
                        `;
                    }
                    $('#sarjana').html(page);
                    $('#form').html(form);
                    $('#file').html(file);
                }
            })
        }
        $('#pendidikan').on('click', '.edit', function(e) {
            e.preventDefault();
            $('#pendidikan').find('input').removeAttr('disabled');
            for (i = 1; i <= 3; i++) {
                $(`#file${i}`).html(`
                <div class="form-group">
                <label for="ijasah_s${i}" class="col-sm-2 control-label">Ijasah S${i}</label>
                <div class="col-sm-10">
                <input type="file" name="ijasah_s${i}" id="ijasah_s${i}" accept="application/pdf" class="form-control">
                </div>
                </div>
                `);
            }
            $('#button').html(`
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-danger cancel">Cancel</button>
                <button type="submit" class="btn btn-success simpan">Simpan</button>
            </div>
            `);
        })
        $('#pendidikan').on('click', '.cancel', function(e) {
            e.preventDefault();
            show_data();
            $('#button').html(`
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary edit">Edit</button>
            </div>
            `);
        })
        $('#pendidikan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url('pendidikan/data') ?>',
                type: 'post',
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: false,
                success: result => {
                    if (result.status == true) {
						toastr["success"](result.pesan);
					} else {
						toastr["error"](result.pesan);
					}
                    show_data();
                    $('#button').html(`
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary edit">Edit</button>
                    </div>
                    `);
                }
            })
        })
    })
</script>
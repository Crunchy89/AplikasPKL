<section class="content-header">
    <h1>
        <?= $judul ?>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Menu Management</h3>
                    <br>
                    <hr>
                    <button type="button" class="btn btn-success btn-sm" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="myData" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Icon</th>
                                    <th>Order</th>
                                    <th>Aktif</th>
                                    <th>Submenu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Nama Menu</label>
                        <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="Nama Menu" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <div class="input-group">
                            <input type="text" name="icon" id="icon" class="form-control form-control-sm" placeholder="Icon" required>
                            <span class="input-group-btn">
                                <button type="button" id="ti" class="btn btn-info btn-flat">Icon</button>
                            </span>
                        </div>
                    </div>
                    <div id="add">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="cons" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tes">
                <div class="modal-body" id="con">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function show_data() {
            $.ajax({
                url: '<?= site_url('admin/menu') ?>',
                type: 'post',
                dataType: 'json',
                success: data => {
                    let menu = ''
                    data.forEach(dat => {
                        let sub = '';
                        dat.submenu.forEach(subm => {
                            sub += `<li data-url="${subm.url}" class="submenu"><a href="#"><i class="${subm.icon}"></i>${subm.title}</a></li>`;
                        })
                        menu += `<li class="treeview">
                            <a href="#">
                            <i class="${dat.icon}"></i>
                            <span>${dat.title}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu submenu">${
                            sub}</ul>
                            </li>`;
                    })
                    $('#menu').html(menu);
                    $('.submenu').on('click', 'li', function() {
                        url = $(this).data('url');
                        $('#show_data').load(`<?= site_url() ?>/${url}`);
                    });
                }
            });
        }
        const form = $('.modal-body').html();
        $('#myData').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('menu/getLists'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }]
        });
        $('#data').on('click', '.down', function() {
            no = $(this).data('order');
            id = $(this).data('id_menu');
            $.ajax({
                url: '<?= site_url('menu/down') ?>',
                type: 'post',
                data: {
                    no_order: no,
                    id_menu: id
                },
                dataType: 'json',
                success: () => {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                }
            })
        });
        $('#data').on('click', '.up', function() {
            no = $(this).data('order');
            id = $(this).data('id_menu');
            $.ajax({
                url: '<?= site_url('menu/up') ?>',
                type: 'post',
                data: {
                    no_order: no,
                    id_menu: id
                },
                dataType: 'json',
                success: () => {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                }
            })
        });
        $('#tambah').click(function() {
            $('.modal-body').html(form);
            aksi = `<input type="hidden" name="aksi" id="aksi" value="tambah">`;
            $('#add').html(aksi);
            $('#modal').find('h5').html('Tambah')
            $('#modal').find('#btn').html('Tambah')
            $('#modal').modal('show');
        });
        $('#data').on('click', '.edit', function() {
            $('.modal-body').html(form);
            aksi = `<input type="hidden" name="aksi" id="aksi" value="edit">
                '<input type="hidden" name="id" id="id" value="${$(this).data('id_menu')}">`;
            $('#add').html(aksi);
            $('#modal').find('h5').html('Edit')
            $('#modal').find('#btn').html('Edit')
            $('#title').val($(this).data('title'));
            $('#icon').val($(this).data('icon'));
            $('#modal').modal('show');
        });
        $('#data').on('click', '.hapus', function() {
            $('.modal-body').html(form);
            aksi = `<input type="hidden" name="aksi" id="aksi" value="hapus">
                <input type="hidden" name="id" id="id" value="${$(this).data('id_menu')}">
                <h3>Apakah Anda Yakin ?</h3>`;
            $('.modal-body').html(aksi);
            $('#modal').find('h5').html('Hapus')
            $('#modal').find('#btn').html('Hapus')
            $('#modal').modal('show');
        });
        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url('menu/aksi') ?>',
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false,
                success: result => {
                    show_data();
                    if (result.status == false) {
                        toastr['error'](result.pesan);
                    } else if (result.status == true) {
                        toastr['success'](result.pesan);
                    }
                    $('#myData').DataTable().ajax.reload();
                    $('#modal').modal('hide');
                }
            })
        });
        $('#data').on('click', '#active', function() {
            id_menu = $(this).data('id_menu');
            active = $(this).data('active');
            $.ajax({
                url: '<?= site_url('menu/active') ?>',
                type: 'post',
                data: {
                    id: id_menu,
                    active: active
                },
                dataType: 'json',
                success: data => {
                    show_data();
                    $('#myData').DataTable().ajax.reload();
                    if (data.active == 'true') {
                        toastr['success']('Menu Aktif')
                    } else {
                        toastr['error']('Menu Nonaktif')
                    }
                }
            })
        });
        $('#data').on('click', '.sub', function() {
            id = $(this).data('id_menu');
            $('#show_data').load(`<?= site_url() ?>/submenu/index/${id}`);
        });
        $('#form').on('click', '#ti', function() {
            $('#cons').modal('show');
            $('#con').html('');
            var getData = function(data) {
                $scope = {};
                $scope.data = data;
                this.getResult = () => $scope.getResult();
                $scope.getResult = () => $($scope.data).find('.fontawesome-icon-list div i');
            }
            $(document).ready(function() {
                $.ajax({
                    url: '<?= site_url('menu/icon') ?>',
                    success: data => {
                        var tp = new getData(data);
                        var hasil = tp.getResult();
                        var icon = '';
                        for (i = 0; i < hasil.length; i++) {
                            icon +=
                                `<div class="col-md-2 col-sm-2"><input type="radio" name="con" value="${hasil[i].className}"><i class="${hasil[i].className}"></i></div>`;
                        }
                        $('#con').html(icon);
                    }
                })
                $('#tes').submit(function(e) {
                    e.preventDefault();
                    icon = $('[name="con"]:checked').val();
                    $('#icon').val(icon);
                    $('#cons').modal('hide');
                })
            });
        });
    });
</script>
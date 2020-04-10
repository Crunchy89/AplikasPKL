<section class="content-header">
	<h1>
		Civitas
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Management Civitas</h3>
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
									<th>NIK</th>
									<th>Nama Lengkap</th>
									<th>Alamat</th>
									<th>No Telepon</th>
									<th>Email</th>
									<th>Website</th>
									<th>Foto</th>
									<th>Pedidikan</th>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="nik">NIK</label>
								<input type="number" name="nik" id="nik" class="form-control form-control-sm" placeholder="NIK" required>
							</div>
							<div class="form-group">
								<label for="nama">Nama Lengkap</label>
								<input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama Lengkap" required>
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" placeholder="Alamat" required></textarea>
							</div>
							<div class="form-group">
								<label for="no_hp">No Telepon</label>
								<input type="number" name="no_hp" id="no_hp" class="form-control form-control-sm" placeholder="No Telepon" required>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Email" required>
							</div>
							<div class="form-group">
								<label for="web">Website</label>
								<input type="text" name="web" id="web" class="form-control form-control-sm" placeholder="Website" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="gambar">Foto</label>
							</div>
							<div class="form-group">
								<label for="gambar" class="col-sm-4" id="reset"><img class="img-fluid" src="<?= base_url() ?>assets/img/noimage.png" id="output" width="150px" height="170px"></label>
								<input type="file" class="custom-file-input" accept="image/*" onchange="loadFile(event)" id="gambar" name="gambar">
							</div>
							<div id="add">
							</div>
						</div>
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

<div class="modal fade" id="pend" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="pendidikan" class="form-horizontal">
				<div class="modal-body">
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
	var loadFile = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
	};
	$(document).ready(function() {
		const form = $('#form').html();
		$('#myData').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?= site_url('civitas/getLists'); ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0],
				"orderable": false
			}]
		});
		$('#tambah').click(function() {
			$('#form').html(form);
			aksi = `<input type="hidden" name="aksi" id="aksi" value="tambah">
			<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="Username" required>
			</div>
			<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password" required>
			</div>
			<div class="form-group">
			<label for="password2">Confirm Password</label>
			<input type="password" name="password2" id="password2" class="form-control form-control-sm" placeholder="Password" required>
			</div>
			`;
			$('#add').html(aksi);
			$('#modal').find('h5,#btn').html('Tambah');
			$('#modal').modal('show');
		});
		$('#data').on('click', '.edit', function() {
			$('#form').html(form);
			aksi = `
			<input type="hidden" name="aksi" id="aksi" value="edit">
			<input type="hidden" name="gambarLama" id="gambarLama" value="${$(this).data('foto')}">
            <input type="hidden" name="id" id="id" value="${$(this).data('civitas')}">`;
			$('#add').html(aksi);
			$('#modal').find('h5,#btn').html('Edit');
			$('#nik').val($(this).data('nik'));
			$('#nama').val($(this).data('nama'));
			$('#alamat').val($(this).data('alamat'));
			$('#no_hp').val($(this).data('tlp'));
			$('#email').val($(this).data('email'));
			$('#web').val($(this).data('website'));
			$('#reset').html(`
			<img src="<?= base_url() ?>/assets/img/profile/${$(this).data('foto')}" id="output" alt="foto" width="150px" height="170px">	
			`)
			$('#modal').modal('show');
		});
		$('#data').on('click', '.hapus', function() {
			$('#form').html(form);
			aksi = `<input type="hidden" name="aksi" id="aksi" value="hapus">
                <input type="hidden" name="id" id="id" value="${$(this).data('civitas')}">
                <h3>Apakah Anda Yakin ?</h3>`;
			$('.modal-body').html(aksi);
			$('#modal').find('h5, #btn').html('Hapus');
			$('#modal').modal('show');
		});
		$('#form').submit(function(e) {
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
					if (result.status == true) {
						toastr["success"](result.pesan);
					} else {
						toastr["error"](result.pesan);
					}
					$('#myData').DataTable().ajax.reload();
					$('#modal').modal('hide');
				}
			})
		})
		$('#data').on('click', '.pendidikan', function() {
			id_civitas = $(this).data('id_civitas');
			show_data(id_civitas);
			$('.modal-footer').html(`
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			<button type="button" class="btn btn-info edit">Edit</button>
			`);
			$('#pend').modal('show');
		})
		$('#pend').on('click', '.edit', function() {
			$('#pendidikan').find('input').removeAttr('disabled');
			for (i = 1; i <= 3; i++) {
				$('#pendidikan').find(`#file${i}`).html(`
                <div class="form-group">
                <label for="ijasah_s${i}" class="col-sm-2 control-label">Ijasah S${i}</label>
                <div class="col-sm-10">
                <input type="file" name="ijasah_s${i}" id="ijasah_s${i}" accept="application/pdf" class="form-control">
                </div>
                </div>
                `);
			}
			$('.modal-footer').html(`
                <button type="button" class="btn btn-danger cancel">Cancel</button>
                <button type="submit" class="btn btn-success simpan">Simpan</button>
            `);
		})
		$('#pend').on('click', '.cancel', function() {
			$id = $('[name="id_civitas"]').val();
			show_data($id);
			$('.modal-footer').html(`
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary edit">Edit</button>
            `);
		})
		$('#pendidikan').submit(function(e) {
			e.preventDefault();
			id = $('[name="id_civitas"]').val();
			$.ajax({
				url: `<?= site_url('pendidikan/data') ?>/${id}`,
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
					show_data(id);
					$('.modal-footer').html(`
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                	<button type="submit" class="btn btn-primary edit">Edit</button>
            		`);
				}
			})
		})

		function show_data(id_civitas) {
			$.ajax({
				url: `<?= site_url('pendidikan/getData') ?>/${id_civitas}`,
				type: 'post',
				dataType: 'json',
				success: data => {
					arr = [];
					val = [];
					ijasah = [];
					val[0] = data.s1;
					arr[0] = data.s1;
					val[1] = data.s2;
					arr[1] = data.s2;
					val[2] = data.s3;
					arr[2] = data.s3;
					ijasah[0] = data.ijasah_s1;
					ijasah[1] = data.ijasah_s2;
					ijasah[2] = data.ijasah_s3;
					page = '';
					forms = '';
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
						forms += `
                        <div class="form-group">
								<input type="hidden" name="id_civitas" value="${data.id_civitas}">
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
					}
					$('.modal-body').html(forms);
					$('#file').html(file);
				}
			})
		}
	});
</script>
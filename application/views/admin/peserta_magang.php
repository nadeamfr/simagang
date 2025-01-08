<?= $this->session->flashdata('pesan'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center w-100">
        <h3 class="card-title mb-1" style="margin-top: 5px;">Halaman Data Peserta Magang</h3>
        <div class="ml-auto">
            <a href="<?= base_url('pesertamagang/tambah') ?>" class="btn btn-info btn-sm"><i class="fas fa-plus"> Tambah Peserta Magang </i></a>
            <a href="<?= base_url('pesertamagang/print') ?>" class="btn btn-info btn-sm"><i class="fas fa-print"> Print </i></a>
            <a href="<?= base_url('pesertamagang/pdf') ?>" class="btn btn-info btn-sm"><i class="fas fa-file"> Export Pdf </i></a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="peserta_magang" class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Asal Kampus/Sekolah</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>Mulai</th>
                    <th>Berakhir</th>
                    <th>Surat Balasan Magang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($magang as $mgn) : ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td><?= $mgn->nama ?></td>
                        <td><?= $mgn->nim ?></td>
                        <td><?= $mgn->asal_kampus_sekolah ?></td>
                        <td><?= $mgn->fakultas ?></td>
                        <td><?= $mgn->prodi ?></td>
                        <td><?= $mgn->mulai ?></td>
                        <td><?= $mgn->berakhir ?></td>
                        <td>
                            <?php if (!empty($mgn->surat_balasan_magang)): ?>
                                <a href="<?= $mgn->surat_balasan_magang ?>" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak Ada File</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button data-toggle="modal" data-target="#edit<?= $mgn->id_peserta_magang ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                            <a href="<?= base_url('pesertamagang/delete/' . $mgn->id_peserta_magang) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($magang as $mgn) { ?>
    <div class="modal fade" id="edit<?= $mgn->id_peserta_magang ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Peserta Magang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('pesertamagang/edit/' . $mgn->id_peserta_magang) ?>" method="POST">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?= $mgn->nama ?>">
                            <?= form_error('nama', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?= $mgn->nim ?>">
                            <?= form_error('nim', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Asal Kampus/Sekolah</label>
                            <input type="text" name="asal_kampus_sekolah" class="form-control" value="<?= $mgn->asal_kampus_sekolah ?>">
                            <?= form_error('asal_kampus_sekolah', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Fakultas</label>
                            <input type="text" name="fakultas" class="form-control" value="<?= $mgn->fakultas ?>">
                            <?= form_error('fakultas', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Prodi</label>
                            <input type="text" name="prodi" class="form-control" value="<?= $mgn->prodi ?>">
                            <?= form_error('prodi', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Mulai</label>
                            <input type="text" name="mulai" class="form-control datepicker" data-provide="datepicker" value="<?= $mgn->mulai ?>">
                            <?= form_error('mulai', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Berakhir</label>
                            <input type="text" name="berakhir" class="form-control datepicker" data-provide="datepicker" value="<?= $mgn->berakhir ?>">
                            <?= form_error('berakhir', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Surat Balasan Magang</label>
                            <input type="text" name="surat_balasan_magang" class="form-control" value="<?= $mgn->surat_balasan_magang ?>">
                            <?= form_error('surat_balasan_magang', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan </button>
                            <button type="reset" class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Reset </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- CSS untuk mengubah background dan border <th> dan <td> -->
<style>
    /* Ubah warna border tabel menjadi hijau */
    table.table-bordered {
        border: 2px solid blue
            /* Border luar tabel */
    }

    /* Ubah warna background dan border header tabel */
    table.table-bordered th {
        background-color: #b8ecff;
        /* Hijau muda untuk header */
        border: 1px solid blue;
        /* Warna border hijau */
        color: #333;
        /* Warna teks */
    }

    /* Ubah warna background dan border sel tabel */
    table.table-bordered td {
        background-color: #e4f8ff;
        /* Hijau sangat muda untuk sel */
        border: 1px solid blue;
        /* Warna border hijau */
        color: #333;
        /* Warna teks */
    }
</style>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Override panah sorting ganda -->
<style>
    /* Hapus panah sorting bawaan template atau Bootstrap */
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        display: none !important;
    }
</style>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#peserta_magang').DataTable({
            "paging": true, // Enable pagination
            "lengthChange": true, // Allow user to change number of rows shown
            "searching": true, // Enable search
            "ordering": true, // Enable column sorting
            "info": true, // Show table info
            "autoWidth": false, // Disable auto column width adjustment
        });
    });
</script>

<style>
    .form-control:not([size]):not([multiple]) {
        background-image: none !important;
        /* Menghilangkan panah bawaan Bootstrap */
    }
</style>
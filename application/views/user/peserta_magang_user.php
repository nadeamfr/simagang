<?= $this->session->flashdata('pesan'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center w-100">
        <h3 class="card-title mb-1" style="margin-top: 5px;">Halaman Data Peserta Magang</h3>
        <div class="ml-auto">
            <!-- <a href="<?= base_url('pesertamagang/tambah') ?>" class="btn btn-info btn-sm"><i class="fas fa-plus"> Tambah Peserta Magang </i></a>
            <a href="<?= base_url('pesertamagang/print') ?>" class="btn btn-info btn-sm"><i class="fas fa-print"> Print </i></a>
            <a href="<?= base_url('pesertamagang/pdf') ?>" class="btn btn-info btn-sm"><i class="fas fa-file"> Export Pdf </i></a> -->
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
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

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
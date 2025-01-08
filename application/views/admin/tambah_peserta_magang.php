<form action="<?= base_url('pesertamagang/tambah_aksi') ?>" method="POST">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" placeholder="Input Nama Peserta Magang">
        <?= form_error('nama', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" placeholder="Input NIM">
    </div>
    <div class="form-group">
        <label>Asal Kampus/Sekolah</label>
        <input type="text" name="asal_kampus_sekolah" class="form-control" placeholder="Input Asal Kampus/Sekolah">
        <?= form_error('asal_kampus_sekolah', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Fakultas</label>
        <input type="text" name="fakultas" class="form-control" placeholder="Input Fakultas">
    </div>
    <div class="form-group">
        <label>Prodi</label>
        <input type="text" name="prodi" class="form-control" placeholder="Input Prodi">
    </div>
    <div class="form-group">
        <label>Mulai</label>
        <input type="text" name="mulai" class="form-control datepicker" data-provide="datepicker" placeholder="Pilih Tanggal Mulai">
        <?= form_error('mulai', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Berakhir</label>
        <input type="text" name="berakhir" class="form-control datepicker" data-provide="datepicker" placeholder="Pilih Tanggal Berakhir">
        <?= form_error('berakhir', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label>Surat Balasan Magang</label>
        <input type="text" name="surat_balasan_magang" class="form-control" placeholder="Input Link Surat Balasan Magang">
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan </button>
    <button type="reset" class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Reset </button>
</form>


<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<!DOCTYPE html>
<html lang="en"><head>
    <title>Data Peserta Magang</title>
</head><body>
    <table>
        <tr class="text-center">
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Asal Kampus/Sekolah</th>
            <th>Fakultas</th>
            <th>Prodi</th>
            <th>Mulai</th>
            <th>Berakhir</th>
        </tr>
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
            </tr>
        <?php endforeach ?>
    </table>
</body></html>
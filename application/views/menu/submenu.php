<div class="row">
    <div class="col-lg">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubmenuModal">Tambah Submenu Baru</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Submenu</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Url</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Aktif</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($subMenu as $sm) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $sm['title']; ?></td>
                        <td><?= $sm['menu']; ?></td>
                        <td><?= $sm['url']; ?></td>
                        <td><?= $sm['icon']; ?></td>
                        <td><?= $sm['is_active']; ?></td>
                        <td>
                        <td>
                            <a href="" class="badge badge-success" data-toggle="modal" data-target="#editSubmenuModal<?= $sm['id']; ?>">Edit</a>
                            <a href="<?= base_url('menu/deletesubmenu/' . $sm['id']); ?>" class="badge badge-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus submenu ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newSubmenuModal" tabindex="-1" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">Tambah Submenu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Nama submenu">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Pilih Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu ikon (https://fontawesome.com/icons)">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit -->
<?php foreach ($subMenu as $sm) : ?>
    <div class="modal fade" id="editSubmenuModal<?= $sm['id']; ?>" tabindex="-1" aria-labelledby="editSubmenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubmenuModalLabel">Edit Submenu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/editsubmenu') ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" value="<?= $sm['title']; ?>" placeholder="Nama submenu">
                            <?= form_error('title', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Pilih Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                    <option value="<?= $m['id']; ?>" <?= $m['id'] == $sm['menu_id'] ? 'selected' : ''; ?>>
                                        <?= $m['menu']; ?>
                                    </option>
                                <?php endforeach; ?>
                                <?= form_error('menu_id', '<div class="text-small text-danger">', '</div>'); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="url" name="url" value="<?= $sm['url']; ?>" placeholder="Submenu url">
                            <?= form_error('url', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="icon" name="icon" value="<?= $sm['icon']; ?>" placeholder="Submenu ikon (https://fontawesome.com/icons)">
                            <?= form_error('icon', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" <?= $sm['is_active'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_active">
                                    Aktif?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<div class="row">
    <div class="col-lg-5">
        <?= $this->session->flashdata('message'); ?>
    </div>
</div>

<div class="card mb-3 col-lg-5">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" style="width: 179px; height: 185px;">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= $user['name'] ?></h5>
                <p class="card-text"><?= $user['email'] ?></p>
                <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']) ?></small></p>
            </div>
        </div>
    </div>
</div>
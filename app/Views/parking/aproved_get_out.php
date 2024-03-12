<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Request to Get Out <?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .container-info {
        max-width: 500px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="app">
    <div class="container-info mx-auto">
        <div class="card mt-3">
            <div class="card-header pb-2">
                <h4 class="card-title text-capitalize"><?= $data['student'] ?></h4>
            </div>
            <div class="card-content">
                <div class="card-body pt-0">
                    <img src="<?= $img_url ?>" alt="id-card" class="img-fluid" style="width:100%;">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-capitalize p-3 text-nowrap"><?= $data['student'] ?></td>
                                </tr>
                                <tr>
                                    <td class="p-3 text-nowrap"><?= $data['nim'] ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize p-3 text-nowrap"><?= $data['vehicle'] ?></td>
                                </tr>
                                <tr>
                                    <td class="p-3 text-nowrap"><?= $data['plat'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="card-title text-capitalize mt-5 mb-3"><?= $data['guard'] ?></h5>
                    <img src="<?= $img_guard_url ?>" alt="id-card" class="img-fluid" style="width:100%;">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-capitalize p-3 text-nowrap"><?= $data['guard'] ?></td>
                                </tr>
                                <tr>
                                    <td class="p-3 text-nowrap"><?= $data['nip'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <p class="m-0">Request to get out</p>
                        <h6 class="mt-2"><?= $ctx->to_readable($data['created_at']) ?> at <?= date('H:i', strtotime($data['created_at'])) ?></h6>
                        <p class="mb-0 mt-4">Aproved</p>
                        <h6 class="mt-2"><?= $ctx->to_readable($data['aproved_at']) ?> at <?= date('H:i', strtotime($data['aproved_at'])) ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Request to Get Out <?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .container-info {
        max-width: 500px;
    }

    #qrcode img {
        margin: auto;
        width: 100%;
    }

    #qrcode canvas {
        width: 100%;
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
                    <img src="<?= base_url('id-card') ?>" alt="id-card" class="img-fluid" style="width:100%;">

                    <div class="table-responsive my-4">
                        <table class="table table-bordered  mb-0">
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
                    
                    <div id="qrcode" class="mx-auto d-block container" data-scan="<?= $data['id'] ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/qrcode-generator/qrcode.min.js') ?>"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', _ => {
        document.documentElement.dataset.bsTheme = 'light'
        const targetElement = document.getElementById("qrcode")
        new QRCode(targetElement, {
            text: targetElement.dataset.scan,
            width: 500,
            height: 500,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    })
</script>
<?= $this->endSection() ?>
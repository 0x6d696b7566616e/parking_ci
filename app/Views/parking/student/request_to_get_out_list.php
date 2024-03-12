<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Request To Get Out <?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/extensions/flatpickr/flatpickr.min.css') ?>" />
<style>
    .clickable {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="app">
    <?= $this->include('partials/sidebar') ?>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Request To Get Out</h3>
                        <p class="text-subtitle text-muted">
                            Request to get out of the parking lot that you requested
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Vehicles
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="row" id="table-hover-row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-content pt-2 pb-3">
                                <!-- table hover -->
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover mb-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th class="p-3 text-nowrap">Brand & Series</th>
                                                <th class="p-3 text-nowrap">Plat Number</th>
                                                <th class="p-3 text-nowrap">Created At</th>
                                                <th class="p-3 text-nowrap">Hours</th>
                                                <th class="p-3 text-nowrap">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $itm) : ?>
                                                <tr>
                                                    <td class="p-3 text-nowrap"><?= $itm['vehicle'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $itm['plat'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $ctx->to_readable($itm['created_at']) ?></td>
                                                    <td class="p-3 text-nowrap"><?= date('H:i', strtotime($itm['created_at'])) ?></td>
                                                    <td class="p-3 text-nowrap"><a href="<?= base_url('dashboard/delete-request-to-get-out/'.$itm['id']) ?>" class="btn btn-warning">Delete</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?= $this->include('partials/pagination') ?>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2023 &copy; E-Parking</p>
                </div>
                <div class="float-end">
                    <p>
                        Crafted with
                        <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                        
                    </p>
                </div>
            </div>
        </footer>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<?= $this->endSection() ?>
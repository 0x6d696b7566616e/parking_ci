<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Update Vehicle <?= $this->endSection() ?>

<?= $this->section('head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/extensions/filepond/filepond.css') ?>" />
    <link
      rel="stylesheet"
      href="<?= base_url('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') ?>"
    />
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
                            <h3>Update Vehicle</h3>
                            <p class="text-subtitle text-muted">
                                Please, fill your vehicle data correctly.
                            </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Create Vehicle
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Your Vehicle Data</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" action="<?= base_url('dashboard/update-vehicle/'.$curr['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama">Brand & Series</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama" class="form-control" required  value="<?= empty(set_value('nama')) ? $curr['nama'] : set_value('nama') ?>"  name="nama" placeholder="Ex. Honda Vario 2018" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('nama')) : '' ?></p>
                                                    </div>
                                                    <div class="col-md-4 mt-md-3">
                                                        <label for="nama">Plat Number</label>
                                                    </div>
                                                    <div class="col-md-8 mt-md-3 form-group">
                                                        <input type="text" id="plat" class="form-control" required  value="<?= empty(set_value('plat')) ? $curr['plat'] : set_value('plat') ?>"  name="plat" placeholder="Ex. AB XXXX XX" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('plat')) : '' ?></p>
                                                    </div>
                                                    <div class="col-12 mt-md-3">
                                                        <p class="text-danger text-center m-0"><?= !empty(session()->getFlashdata('error')) ? session()->getFlashdata('error') : '' ?></p>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-end mt-5">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                                            Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                            Reset
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
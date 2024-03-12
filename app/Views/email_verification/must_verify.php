<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Request To Get Out <?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/extensions/flatpickr/flatpickr.min.css') ?>" />
<style>
    .w-fit {
        width: -moz-fit-content;
        width: fit-content;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="app">
    <div id="main" class="mx-auto">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Email Verification</h3>
                        <p class="text-subtitle text-muted">
                            Please verify your email address.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Email Verification</a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="row" id="table-hover-row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content py-4">
                                <h4 class="card-title mb-5 text-center">Please verify your email address.</h4>
                                <p class="text-center mb-3">Didn't receive the email?</p>
                                <form action="<?= base_url('request-to-verify') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-primary mx-auto d-block">Click Here</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.js') ?>"></script>

<?php if (!empty(session()->getFlashdata('success'))) : ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: `<?= session()->getFlashdata('success') ?>`,
        })
    </script>
<?php endif; ?>

<?php if (!empty(session()->getFlashdata('error'))) : ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Error",
            text: `<?= session()->getFlashdata('error') ?>`,
        })
    </script>
<?php endif; ?>
<?= $this->endSection() ?>
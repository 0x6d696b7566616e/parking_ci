<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Email Verification <?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/compiled/css/auth.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="index.html"><img src="<?= base_url('assets/compiled/svg/logo.svg') ?>" alt="Logo" /></a>
                </div>
                <h2 class="mb-5">Verify Email.</h2>
                <form action="<?= base_url('verify-email') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" readonly value="<?= $token ?>">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl" required value="<?= set_value('email') ?>" name="email" placeholder="Your New Email" />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <p class="text-danger mt-2 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('email')) : '' ?></p>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl" required value="<?= set_value('password') ?>" name="password" placeholder="Password" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <p class="text-danger mt-2 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('password')) : '' ?></p>
                    </div>
                    <p class="text-danger text-center mt-2 mb-0"><?= isset($error) ? $error : '' ?></p>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        Verify
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
    <script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.js') ?>"></script>
    <?php if(!empty(session()->getFlashdata('error'))): ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: `<?= session()->getFlashdata('error') ?>`,
            })
        </script>
    <?php endif; ?>
<?= $this->endSection() ?>
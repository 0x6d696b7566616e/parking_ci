<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Login <?= $this->endSection() ?>

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
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">
                    Log in with your data as a Security Guard.
                </p>

                <form action="<?= base_url('guard/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" required value="<?= set_value('email') ?>" name="email" placeholder="yours@mail.com" />
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
                        Log in
                    </button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="<?= base_url('guard/register') ?>" class="font-bold">Sign up</a>.
                    </p>
                    <!-- <p>
                        <a class="font-bold" href="forgot-password.html">Forgot password?</a>.
                    </p> -->
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
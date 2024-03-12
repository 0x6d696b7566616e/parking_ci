<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Profile <?= $this->endSection() ?>

<?= $this->section('head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/extensions/filepond/filepond.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.css') ?>" />
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
                            <h3>Update Profile</h3>
                            <p class="text-subtitle text-muted">
                                Please, complete your data correctly.
                            </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Update Profile
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
                                    <h4 class="card-title">Basic Data</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" action="<?= base_url('dashboard/update-profile') ?>" method="post" enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama">Full Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama" class="form-control" required  value="<?= empty(set_value('nama')) ? $curr['nama'] : set_value('nama') ?>"  name="nama" placeholder="Full Name" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('nama')) : '' ?></p>
                                                    </div>
                                                    <div class="col-md-4 mt-md-3">
                                                        <label for="nama">Study Program</label>
                                                    </div>
                                                    <div class="col-md-8 mt-md-3 form-group">
                                                        <input type="text" id="prodi" class="form-control" required  value="<?= empty(set_value('prodi')) ? $curr['prodi'] : set_value('prodi') ?>"  name="prodi" placeholder="Ex. D3 Teknik Informatika" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('prodi')) : '' ?></p>
                                                    </div>
                                                    <div class="col-md-4 mt-md-3">
                                                        <label for="id-card">Student ID Card</label>
                                                    </div>
                                                    <div class="col-12 mt-1 mt-md-2">
                                                        <input type="file" name="id_card" id="id-card" class="image-preview-filepond mb-0" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('id_card')) : '' ?></p>
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
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Authentication Data</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="<?= base_url('dashboard/update-email') ?>">
                                            <?= csrf_field() ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="email">Student Email</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="email" id="email" class="form-control" value="<?= empty(set_value('email')) ? $curr['email'] : set_value('email') ?>" required name="email" placeholder="Student Email" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('email')) : '' ?></p>
                                                    </div>
                                                    <div class="col-md-4 mt-md-3">
                                                        <label for="password">Confirm Password</label>
                                                    </div>
                                                    <div class="col-md-8 form-group mt-md-3">
                                                        <input type="password" id="password" class="form-control" required name="confirm_password" placeholder="" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('confirm_password')) : '' ?></p>
                                                    </div>
                                                    <div class="col-12 mt-md-3">
                                                        <p class="text-danger text-center m-0"><?= !empty(session()->getFlashdata('error_email')) ? session()->getFlashdata('error_email') : '' ?></p>
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
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Sensitive Data</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="<?= base_url('dashboard/update-nim') ?>">
                                            <?= csrf_field() ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nim">NIM</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nim" class="form-control" value="<?= empty(set_value('nim')) ? $curr['nim'] : set_value('nim') ?>" required name="nim" placeholder="21.01.XX" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('nim')) : '' ?></p>
                                                    </div>
                                                    <div class="col-md-4 mt-md-3">
                                                        <label for="password">Confirm Password</label>
                                                    </div>
                                                    <div class="col-md-8 form-group mt-md-3">
                                                        <input type="password" id="password" class="form-control" required name="confirm_password" placeholder="" />
                                                        <p class="text-danger mt-1 mb-0"><?= isset($validation) ? str_replace('_', ' ', $validation->getError('confirm_password')) : '' ?></p>
                                                    </div>
                                                    <div class="col-12 mt-md-3">
                                                        <p class="text-danger text-center m-0"><?= !empty(session()->getFlashdata('error_nim')) ? session()->getFlashdata('error_nim') : '' ?></p>
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
    
    <script src="<?= base_url('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/filepond/filepond.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/toastify-js/src/toastify.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
        )

        FilePond.create(document.querySelector(".image-preview-filepond"), {
            credits: null,
            storeAsFile: true,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                // Do custom type detection here and return with promise
                resolve(type)
                }),
            })
    </script>
    
    <?php if(!empty(session()->getFlashdata('warning'))): ?>
        <script>
            Swal.fire({
                icon: "warning",
                title: "Warning",
                text: `<?= session()->getFlashdata('warning') ?>`,
            })
        </script>
    <?php endif; ?>

    
    <?php if(!empty(session()->getFlashdata('email'))): ?>
        <script>
            Swal.fire({
                icon: "warning",
                title: "Email Verification",
                text: `<?= session()->getFlashdata('email') ?>`,
            })
        </script>
    <?php endif; ?>
<?= $this->endSection() ?>
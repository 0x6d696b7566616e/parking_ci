<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Create Vehicle <?= $this->endSection() ?>

<?= $this->section('head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.css') ?>" />
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
                        <h3>Vehicle</h3>
                        <p class="text-subtitle text-muted">
                            List of your registered vehicles
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
                        <div class="card">
                            <div class="card-header p-3">
                                <a href="<?= base_url('dashboard/create-vehicle') ?>" class="btn btn-primary">Register your vehicle</a>
                            </div>
                            <div class="card-content pt-2 pb-3">
                                <!-- table hover -->
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover mb-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th class="p-3 text-nowrap">Brand & Series</th>
                                                <th class="p-3 text-nowrap">Plat Number</th>
                                                <th class="p-3 text-nowrap">Get Out of Parking</th>
                                                <th class="p-3 text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($vehicles as $vehicle) : ?>
                                                <tr>
                                                    <td class="p-3 text-nowrap"><?= $vehicle['nama'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $vehicle['plat'] ?></td>
                                                    <td class="p-3">
                                                        <form action="<?= base_url('dashboard/request-to-get-out/'.$vehicle['id']) ?>" class="out-parkings-form" method="post">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="created_at" class="created_at" readonly>
                                                            <button class="btn btn-warning">Go Out</button>
                                                        </form>
                                                    </td>
                                                    <td class="p-3 text-nowrap">
                                                        <div class="d-flex">
                                                            <a href="<?= base_url('dashboard/update-vehicle/'.$vehicle['id']) ?>" class="me-2">
                                                                <i class="text-primary badge-circle badge-circle-light-secondary font-medium-1" data-feather="edit"></i>
                                                            </a>                                                                
                                                            <a href="<?= base_url('dashboard/delete-vehicle/'.$vehicle['id']) ?>" class="delete-button">
                                                                <i class="text-danger badge-circle badge-circle-light-secondary font-medium-1" data-feather="trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
    <script src="<?= base_url('assets/extensions/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/extensions/dayjs/dayjs.min.js') ?>"></script>
    <script>
        window.addEventListener('DOMContentLoaded', _ => {
            document.querySelectorAll('.out-parkings-form').forEach(itm => {
                itm.addEventListener('submit', e => {
                    e.preventDefault()
                    itm.querySelector('.created_at').value = dayjs().format('YYYY-MM-DD HH:mm:ss')
                    itm.submit()
                })
            })

            document.querySelectorAll(".delete-button").forEach(itm => {
                itm.addEventListener("click", (e) => {
                    e.preventDefault()
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: 'This action cant be undo, are you sure to delete this vehicle?',
                    })
                    .then(_ => window.location.replace(itm.href))
                })
            })
        })
    </script>

    <?php if(!empty(session()->getFlashdata('error_get_out'))): ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: `<?= session()->getFlashdata('error_get_out') ?>`,
            })
        </script>
    <?php endif; ?>
<?= $this->endSection() ?>
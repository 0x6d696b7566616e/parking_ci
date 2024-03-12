<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Security Guard <?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/extensions/flatpickr/flatpickr.min.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="app">
    <?= $this->include('partials/sidebar_guard') ?>
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
                        <h3>Security Guard</h3>
                        <p class="text-subtitle text-muted">
                            All of security guard that registered
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
                            <div class="card-content pt-2 pb-3">
                                <!-- table hover -->
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover mb-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th class="p-3 text-nowrap">Name</th>
                                                <th class="p-3 text-nowrap">Email</th>
                                                <th class="p-3 text-nowrap">NIP</th>
                                                <th class="p-3 text-nowrap">Account Activation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $itm) : ?>
                                                <tr>
                                                    <td class="p-3 text-nowrap"><?= $itm['nama'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $itm['email'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $itm['nip'] ?></td>
                                                    <?php if((bool)$itm['is_active']): ?>
                                                        <td class="p-3 text-nowrap">
                                                            <form action="<?= base_url('guard/inactivate/'.$itm['id']) ?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <button class="btn btn-warning">Inactivate</button>
                                                            </form>
                                                        </td>
                                                    <?php else: ?>
                                                        <td class="p-3 text-nowrap">                                                            
                                                            <form action="<?= base_url('guard/activate/'.$itm['id']) ?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <button class="btn btn-success">activate</button>
                                                            </form>
                                                        </td>
                                                    <?php endif ?>
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
<script src="<?= base_url('assets/extensions/flatpickr/flatpickr.min.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', _ => {
        const now = new Date()
        const end = new Date()
        end.setDate(end.getDate() + 30)

        document.querySelectorAll('.clickable').forEach(itm => {
            itm.addEventListener('click', _ => {
                if (!itm.dataset?.href) return
                window.location.href = (itm.dataset?.href);
            })
        })

        const instance = flatpickr('.flatpickr-range-preloaded', {
            dateFormat: "Y-m-d", 
            mode: 'range',
            defaultDate: [now.toISOString(), end.toISOString()]
        })

        document.getElementById('filter-form').addEventListener('submit', e => {
            e.preventDefault()
            document.getElementById('filter-form').querySelector('input[name="end_date"]').setAttribute('value', flatpickr.formatDate(instance.selectedDates[1], 'Y-m-d'))
            document.getElementById('filter-form').querySelector('input[name="start_date"]').setAttribute('value', flatpickr.formatDate(instance.selectedDates[0], 'Y-m-d'))
            e.currentTarget.submit()
        })
    })
</script>
<?= $this->endSection() ?>
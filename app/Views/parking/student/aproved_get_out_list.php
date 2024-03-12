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
                        <div class="card">
                            <div class="card-header p-3">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                    Filter
                                </button>
                                <!--login form Modal -->
                                <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">
                                                    Search Filter
                                                </h4>
                                                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form action="<?= base_url('search') ?>" id="filter-form" method="get">
                                                <div class="modal-body">
                                                    <span>Search For: </span>
                                                    <div class="d-flex flex-column mt-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="search_for" id="student" value="student" checked />
                                                            <label class="form-check-label" for="student">
                                                                Student
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="search_for" id="nim" value="nim" />
                                                            <label class="form-check-label" for="nim">
                                                                NIM
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="search_for" id="brand" value="brand" />
                                                            <label class="form-check-label" for="brand">
                                                                Vehicle
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="search_for" id="plat" value="plat" />
                                                            <label class="form-check-label" for="plat">
                                                                Plat Number
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="search_for" id="guard" value="guard" />
                                                            <label class="form-check-label" for="guard">
                                                                Guard
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input id="keywords" type="text" placeholder="Search..." name="keywords" class="form-control" />
                                                    </div>
                                                    <span class="mt-4 d-block">Date Range: </span>
                                                    <div class="d-flex flex-column mt-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="date_range" id="created" value="created_at" checked />
                                                            <label class="form-check-label" for="created">
                                                                Created at
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="date_range" id="aproved" value="aproved_at" />
                                                            <label class="form-check-label" for="aproved">
                                                                Aproved at
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input
                                                            type="date"
                                                            class="form-control flatpickr-range-preloaded"
                                                            placeholder="Select date.."
                                                        />
                                                        <input type="hidden" readonly name="start_date">
                                                        <input type="hidden" readonly name="end_date">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        <span class="">Close</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                                        <span class="">Submit</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content pt-2 pb-3">
                                <!-- table hover -->
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover mb-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th class="p-3 text-nowrap">Student</th>
                                                <th class="p-3 text-nowrap">NIM</th>
                                                <th class="p-3 text-nowrap">Brand & Series</th>
                                                <th class="p-3 text-nowrap">Plat Number</th>
                                                <th class="p-3 text-nowrap">Created At</th>
                                                <th class="p-3 text-nowrap">Aproved At</th>
                                                <th class="p-3 text-nowrap">Guard</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($exits_aproved as $aproved) : ?>
                                                <tr class="clickable" data-href="<?= base_url('aproved-request/' . $aproved['id_out_of_parking']) ?>">
                                                    <td class="p-3 text-nowrap"><?= $aproved['student'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $aproved['nim'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $aproved['vehicle'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $aproved['plat'] ?></td>
                                                    <td class="p-3 text-nowrap"><?= $ctx->to_readable($aproved['created_at']) ?></td>
                                                    <td class="p-3 text-nowrap"><?= $ctx->to_readable($aproved['aproved_at']) ?></td>
                                                    <td class="p-3 text-nowrap"><?= $aproved['guard'] ?></td>
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
<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?> Request to Get Out <?= $this->endSection() ?>

<?= $this->section('head') ?>

<link rel="stylesheet" href="<?= base_url("assets/extensions/toastify-js/src/toastify.css") ?>" />
<style>
    .container-info {
        max-width: 500px;
    }

    #html5-qrcode-button-camera-start,
    #html5-qrcode-button-camera-permission,
    #html5-qrcode-button-camera-stop
    {
        border: 0;
        outline: none;
        padding: 8px 17px;
    }

    #html5-qrcode-anchor-scan-type-change {
        display: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="app">
    <div class="container-info mx-auto">
        <div class="card mt-3">
            <div class="card-content">
                <div class="card-body">
                    <div id="reader" width="600px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url("assets/extensions/toastify-js/src/toastify.js") ?>"></script>
<script src="<?= base_url('assets/extensions/dayjs/dayjs.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/extensions/scan-qr/scan.min.js') ?>"></script>

<script>    
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        {
            useBarCodeDetectorIfSupported: true,
            formatsToSupport: ['QR_CODE'],
            fps: 1,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        /* verbose= */
        false
    );

    async function onScanSuccess(decodedText, decodedResult) {
        try {
            const base_url = `<?= base_url('guard/dashboard/aproved') ?>`
            const raw = await fetch(`${base_url}?decoded=${decodedText}&aproved_at=${dayjs().format('YYYY-MM-DD HH:mm:ss')}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            const res = await raw.json()
            
            Toastify({
                text: res?.message,
                duration: 1500,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: res?.status === 'warning' ? '#ffc107' : res?.status === 'success' ? '#198754' : '#dc3545',
            }).showToast()
        } catch (er) {    
            console.error(er.message)
                    
            Toastify({
                text: 'Server Error',
                duration: 1500,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: '#dc3545',
            }).showToast()
        }
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<?= $this->endSection() ?>
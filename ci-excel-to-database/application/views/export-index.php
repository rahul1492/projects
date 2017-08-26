<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Export Excel</title>

        <link rel="stylesheet" href="<?= base_url()?>/assets/style.css" />
    </head>
    <body>

        <div id="container">
            <h1>Export Excel</h1>

            <div id="body">
                <?= form_open_multipart(base_url('export/download'))?>
                <div class="padd-top-20">
                    <?= form_submit(array('name' => 'btnSubmit', 'value' => 'Download'))?>
                    <?= anchor(site_url(), 'Kembali')?>
                </div>
                <?= form_close()?>
            </div>

            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
        </div>

    </body>
</html>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Signature Pad demo</title>

        <link rel="stylesheet" href="<?= base_url() ?>assets/css/signature-pad.css">
    </head>
    <body onselectstart="return false">

        <div id="signature-pad" class="m-signature-pad">
            <div class="m-signature-pad--body">
                <canvas></canvas>
            </div>
            <div class="m-signature-pad--footer">
                <div class="description">Sign above</div>
                <button type="button" class="button clear" data-action="clear">Clear</button>
                <button type="button" class="button save" data-action="save">Save</button>
            </div>
        </div>

        <script type="text/javascript">
            var url = '<?= base_url() ?>Signature/convertToImg';
        </script>
        <script src="<?= base_url() ?>assets/js/signature_pad.js"></script>
        <script src="<?= base_url() ?>assets/js/app.js"></script>
        
    </body>
</html>

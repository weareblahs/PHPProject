<?php
require_once '../../elements/layout_lite.php';
head_withotherscripts();
?>
<script src="/admin/validate/html5-qrcode.min.js"></script>
<?php head_withotherscripts_closing(); ?>

<div class="" style="padding: 1em 0; height: 100vh">
    <center>
        <div>
            <h5 class="text-center"><i class="fa fa-ticket" aria-hidden="true"></i> Ticket validation</h5>
        </div>
        <div class="container" style="width: 50%">
            <div>
                <div id="reader" style="width: 100%; margin-top: auto; margin-bottom: auto"></div>
            </div>
            <div>
                <h5 class="text-center p-2"><i class="fa fa-qrcode" aria-hidden="true"></i> Please show the QR Code to the camera</h5>
            </div>
    </center>
    <form action="/admin/validate/validate.php" method="POST" id="validationForm">
        <input type="hidden" name="ticketID" id="ticketID">
    </form>
    <audio src="/admin/validate/vadilationNotificationSound.ogg" id="notificationAudio" hidden></audio>
</div>
<?php
endofpage_withotherscripts();
?>
<script>
    let validationForm = document.getElementById('validationForm')

    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        document.getElementById("notificationAudio").play();
        console.log(decodedResult['decodedText']);
        document.getElementById("ticketID").setAttribute('value', decodedResult['decodedText']);
        validationForm.submit()
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 30,
            qrbox: 350
        });
    html5QrcodeScanner.render(onScanSuccess);
</script>
<?php
endofpage_withotherscripts_closing(); ?>
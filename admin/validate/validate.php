<?php
$ticketID = $_POST['ticketID'];

header("Location: /admin/validate/status.php?tid=" . $ticketID);

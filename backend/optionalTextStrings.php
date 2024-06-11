<?php

//set payment gateway text (as HTML code)
require_once 'gateway/config.php';
$paymentText = 'Your payments are processed via ' . $gatewayName;

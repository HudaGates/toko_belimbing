<?php
	$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
	if (!$msg) $msg = "Le site du spipu\r\nhttp://spipu.net/";


	$err = isset($_GET['code']) ? $_GET['code'] : '';
	if (!in_array($err, array('C39'))) $code = 'C39';
	
	require_once('barcode.php');
	
	$qrcode = new QRcode(utf8_encode($msg), $code);
	$qrcode->disableBorder();
	$qrcode->displayPNG(200);
?>
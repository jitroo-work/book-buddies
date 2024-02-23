<?php
	session_start();

	$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
	$file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");
	if ($file != null) {
		$date = new DateTime("now", new DateTimeZone('Asia/Manila') );

		$outputString = $username . " - logged out " .  $date->format('l jS \of F Y h:i:s a') . "\n\n";

	fwrite($file, $outputString, strlen($outputString));
	}fclose($file);

	$_SESSION['cartBookIdArray'] = [];
	$_SESSION['cartBookQtyArray'] = [];

	session_destroy();

	header('location:home.php');
?>

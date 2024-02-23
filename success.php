<?php
include("header.php");

if (!@$_SESSION['username']) {
  header('location:login.php');
}

$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
$file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");
if ($file != null)
{
  $date = new DateTime("now", new DateTimeZone('Asia/Manila') );
  $outputString = " - made a purchase on " . $date->format('l jS \of F Y h:i:s a') . " containing " . count($_SESSION["cartBookIdArray"]) . " item(s)\n";

  $_SESSION['cartBookIdArray'] = [];
  $_SESSION['cartBookQtyArray'] = [];

fwrite($file, $outputString, strlen($outputString));
}

fclose($file);

?>
<!DOCTYPE html>
<html>
<head>
  <title>BOOK BUDDIES</title>
</head>
<body>
<div class="container-fluid">
	<div class="row align-items-center success-section">
    <div class="cover">
      <img src="img/success.png">
    </div>
		<span class="success-main">Success!</span><br>
    <span class="success-sub">Your purchase has been successful and its details have been logged.</span><br>
    <a href="home.php" class="success-back"><button type="button" class="btn btn-orange">Back to Home</button></a>
	</div>
</div>

<?php include("footer.php"); ?>
</body>
</html>

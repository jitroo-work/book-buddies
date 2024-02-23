<?php
	include("header.php");

	$dbError = mysqli_connect_errno();
	if ($dbError){
		echo "Error: " . $dbError;
	} else {
		$query = "SELECT id, title, price, image_name as img FROM book;";

		$result = $db->query($query);
		$resultCount = $result->num_rows;
	}

	function outFunction($username) {
		$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

		$file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");

		if ($file != null) {
			$date->set_timezone(new timezone_open('Asia/Manila'));
			$outputString = $username . " - logged out " .  $date->format('l jS \of F Y h:i:s A') . "\n";

			fwrite($file, $outputString, strlen($outputString));
		}
		fclose($file);
	}
?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
		function onLoad() {
			var element = document.getElementById("home");
			element.classList.add("active");
		}
	</script>

	<title>HOME</title>
</head>
<body onload="onLoad()" class="text-center">
<div class="container-fluid">
	<div class="row title-bar">
		<div class="col-10">
			<h1>BOOK BUDDIES</h1>
		</div>
	</div>
</div>

<?php include('topnav.php'); ?>

<div class="container-fluid">
	<br>
	<?php
	if ($resultCount != 0) {
		echo "<div class=row row-cols-1 row-cols-md-3 g-4'>";
		for ($i = 0 ; $i < $resultCount ; $i++) {
			$row = $result->fetch_assoc();

			if ($i % 3 == 0 && $i !=0) {
				echo "</div><br>";
				echo "<div class='row row-cols-1 row-cols-md-3 g-4'>";
			}

			echo "	<div class='col'>";
			echo "		<div class='card h-100'>";
			echo "			<a href='viewBook.php?id=" . $row['id'] ."'><img src='img/".$row['img']."' class='card-img-top'></a>";
			echo "			<div class='card-body'>";
			echo "				<h5 class='card-title'>".$row['title']."</h5>";
			echo "			</div>";
			echo "			<div class='card-footer'>";
			echo "				<h6> PHP ".number_format($row['price'], 2, '.', ',')."</h6>";
			echo "			</div>";
			echo "		</div>";
			echo "	</div>";
		}
	}
	?>
	</div>
	<div class="row"><br><br><br><br></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>

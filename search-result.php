<?php
	include('header.php');

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : null;

		if (!$searchTerm) {
			echo "You have not entered search details!";
		} else {

			$dbError = mysqli_connect_errno();

			if ($dbError){
				echo "Error: " . $dbError;
			} else {
				$query = "SELECT author.name as author_name, book.id, book.title, book.isbn, book.price, book.image_name".
					" FROM book INNER JOIN author ON book.author_id=author.id".
					" WHERE author.name LIKE '%" . $searchTerm ."%' OR book.title LIKE '%" . $searchTerm . "%';";

				$result = $db->query($query);
				$resultCount = $result->num_rows;
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
		function onLoad() {
			var element = document.getElementById("search");
			element.classList.add("active");
		}
	</script>

	<title>SEARCH RESULT</title>
</head>
<body onload="onLoad()">
<div class="container-fluid">
	<div class="row title-bar">
		<div class="col-10">
			<h1>SEARCH</h1>
		</div>
	</div>
</div>

<?php include('topnav.php'); ?>

<div class="container-fluid">
	<br>
	<button type="button" class="btn btn-secondary back2" onclick="window.location.href='search.php'">Back</button>
	<div class="row row-cols-1 row-cols-md-3 g-4">
		<?php

			for ($i = 0 ; $i < $resultCount ; $i++) {
				$row = $result->fetch_assoc();
				echo "<div class='col'>";
				echo "	<div class='card h-100'>";
				echo "		<img src='img/" . $row['image_name'] . "' class='card-img-top'>";
				echo "		<div class='card-body'>";
				echo "			<h6 class='card-title'>" . $row['title'] . "</h6>";
				echo "			<p>" . $row['author_name'] . "<br>";
				echo "			".$row['isbn'] . "<br> PHP " . number_format($row['price'], 2, '.', ',')."</p>";
				echo "		</div>";
				echo "		<div class='card-footer text-end'>";
				echo "			<a href='viewBook.php?id=" . $row['id'] ."' class='btn btn-primary'>View</a></div>";
				echo "</div></div>";
			}
		?>
    </div>
</div><br><br><br>
<?php include("footer.php"); ?>
</body>
</html>

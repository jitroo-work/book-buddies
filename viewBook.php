<?php
include("header.php");

$bookId = $_GET['id'];

$dbError = mysqli_connect_errno();
if ($dbError){
	echo "Error: " . $dbError;
} else {
	$query = "SELECT author.name as author, book.title, book.description, book.price, book.image_name as img FROM book INNER JOIN author ON book.author_id = author.id WHERE book.id =" . $bookId . ";";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function onLoad() {
			var element = document.getElementById("<?php echo $row['title'];?>");
			element.classList.add("active");
		}
	</script>

	<title>View | <?php echo $row['title']; ?></title>
</head>
<body onload="onLoad()">
<div class="container-fluid">
	<div class="row title-bar">
		<div class="row">
			<div class="col-auto">
				<button type="button" class="btn btn-secondary back" onclick="window.location.href='home.php'">Back</button>
			</div>
			<div class="col-auto"><h1>BOOK BUDDIES</h1></div>
		</div>
	</div>
</div>

<?php include('topnav.php'); ?>

<div class="container-fluid">
	<div class="row cover">
		<div class="col-5 cover">
			<img src="./img/<?php echo $row['img']; ?>" width="80%">
		</div>
		<div class="col-7 gradient">
		<?php
			echo "<h1>".$row['title']."</h1>";
			echo "<h4>".$row['author']."</h4>";
			echo "<p class='book-info'>".$row['description']."</p><br>";
			echo "<h6>PHP ". number_format($row['price'], 2, '.', ',')."</h6>";
		?><br>
			<form class="row" action="cart.php" method="post">
			   	<div class="mb-2 row">
			   		<label for="qty" class="col-sm-3 col-form-label">Quantity : </label>
				    <div class="col-auto">
				      <input type="number" class="form-control" name="bookQty" value="1" min="1">
							<input type="hidden" name="bookId" value="<?php echo $bookId ?>">
				    </div>
						<?php addwrite(); ?>
				    <div class="col-auto">
			     		<button type="submit" class="btn btn-orange bi bi-cart-plus" name="addCart"> | Add to Cart</button>
			  		</div>
			  	</div>
			</form>
			<br>
		</div>
	</div>
</div><br>

<?php include("footer.php"); ?>
</body>
</html>

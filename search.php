<?php include('header.php'); ?>
<!DOCTYPE html>
<html>
<head>    
    <script type="text/javascript">
		function onLoad() {
			var element = document.getElementById("search");
			element.classList.add("active");
		}
	</script>

	<title>SEARCH</title>
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

<?php include('topnav.php'); ?><br><br>
<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<p><b>Search Book</b></p>
			<form action="search-result.php" method="post">
				<div class="form-group">
					<input type="text" name="searchTerm" class="form-control" required>
				</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>	
</body>
</html>
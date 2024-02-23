<?php
	include("header.php");

	if (@$_SESSION['username']) {
		header('location:home.php');
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$first_name = isset($_POST['firstname']) ? $_POST['firstname'] : null;
		$middle_name = isset($_POST['middlename']) ? $_POST['middlename'] : null;
		$last_name = isset($_POST['lastname']) ? $_POST['lastname'] : null;
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		$username = isset($_POST['username']) ? $_POST['username'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;

		$dbError = mysqli_connect_errno();
		if ($dbError){
			echo "Error: " . $dbError;
		} else {
			if (!empty($first_name)){
				$message = register($db, $first_name, $middle_name, $last_name, $email, $username, $password);
			} else{
				$message = login($db, $username, $password);
			}
		}
	}

	function login($db, $username, $password) {
		$password = hash('sha512', $password);
		$query = "SELECT id, username, password FROM users WHERE username='" . $username . "' AND password='" . $password . "';";

		$result = $db->query($query);
		$resultCount = $result->num_rows;

		if ($resultCount == 0) {
			$message = "Please enter the correct credentials.";
		} else {
			$result = $result->fetch_assoc();
			$_SESSION['username'] = $result['username'];
			$_SESSION['cartBookIdArray'] = [];
			$_SESSION['cartBookQtyArray'] = [];
			loginWrite($username);
			header('location:home.php');
		}
		return $message;
	}

	function register($db, $first_name, $middle_name, $last_name, $email, $username, $password) {
		$password = hash('sha512', $password);
		$query = "INSERT INTO users(first_name, middle_name, last_name, email, username, password) VALUES ('" . $first_name . "','" . $middle_name . "','" . $last_name . "','" . $email . "','" . $username . "','" . $password . "');";

		$result = $db->query($query);

		if (empty($result)) {
			$message = "User already exists.";
		} else {
			registerWrite($username);
			$message = "You are now Registered! You may now log in and shop!";
		}
		return $message;
	}

	function loginWrite($username) {
		$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

		$file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");

		if ($file != null) {
			$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
			$outputString = $username . "\n - logged in " .  $date->format('l jS \of F Y h:i:s a') . " at " . $_SERVER['REMOTE_ADDR'] . "\n";

			fwrite($file, $outputString, strlen($outputString));
		}
		fclose($file);
	}

	function registerWrite($username) {
		$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

		$file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");

		if ($file != null) {
			$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
			$outputString = $username . " registered this " .  $date->format('l jS \of F Y h:i:s a') . " at " . $_SERVER['REMOTE_ADDR'] . "\n\n";

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
			var element = document.getElementById("login");
			element.classList.add("active");
		}
	</script>

	<title>Login</title>
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
	<div class="row login">
		<div class="col-7 login">
		<h1><b><center>Log-in</center></b></h1>
		<?php
			if (!empty($message)){
				echo "<div class='alert alert-primary' role='alert'>" . $message . "</div>";
			}
		?>
			<form action="login.php" method="post">
			<div class="form-group">
				<div class="form-floating">
					<input type="text" name="username" class="form-control" placeholder="username" required>
					<label for="floatingInput">Username</label>
				</div>
			</div>
			<br>
			<div class="form-group">
				<div class="form-floating">
					<input type="password" name="password" class="form-control" placeholder="password" required>
					<label for="floatingInput">Password</label>
				</div>
				<br>
				<button type="submit" class="btn-round btn-primary">Login</button>
			</form>
			</div>
		</div>

		<div class="col-5 gradient">
			<div class="gradient-content">
				<h1>Bonjour!</h1><br>
				<p>New here and you want to Shop?</p>
				<p>Register now.</p><br>
				<button type="button" class="btn-round btn-orange" data-bs-toggle="modal" data-bs-target="#register">Register</button>
			</div>
		</div>
	</div>
</div>

<!-- REGISTER MODAL -->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="register" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Register here</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="login.php" method="POST">
					<div class="form-group">
						<div class="form-floating">
							<input type="text" name="firstname" class="form-control" placeholder="name" required>
							<label for="floatingInput">First Name</label>
						</div>
					</div><br>
					<div class="form-group">
						<div class="form-floating">
							<input type="text" name="middlename" class="form-control" placeholder="name">
							<label for="floatingInput">Middle Name</label>
						</div>
					</div><br>
					<div class="form-group">
						<div class="form-floating">
							<input type="text" name="lastname" class="form-control" placeholder="name" required>
							<label for="floatingInput">Last Name</label>
						</div>
					</div><br>
					<div class="form-group">
						<div class="form-floating">
							<input type="email" name="email" class="form-control" placeholder="name" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" required>
							<label for="floatingInput">Email</label>
						</div>
					</div><br>
					<div class="form-group">
						<div class="form-floating">
							<input type="text" name="username" class="form-control" placeholder="username" required>
							<label for="floatingInput">Username</label>
						</div>
					</div><br>
					<div class="form-group">
						<div class="form-floating">
							<input type="password" name="password" class="form-control" placeholder="password" minlength="8" required>
							<label for="floatingInput">Password</label>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn-round btn-pink">Sign-up</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>

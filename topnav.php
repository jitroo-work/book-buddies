<nav class="navbar navbar-expand-lg navbar-light bg-dark">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="btn btn-light navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item" id="home">
					 <a class="nav-link" href="home.php">Home</a>
				</li>
				<li class='nav-item' id='search'>
					<a class="nav-link" href="search.php">Search</a>
				</li>
				<?php if(@!$row['title']){ ?>
					<!-- none -->
				<?php }else { ?>
				<li class='nav-item' id='<?php echo $row['title'];?>'>
					<a class="nav-link" href=""><?php echo " | " . @$row['title']; ?></a>
				</li>
				<?php } ?>
			</ul>
			<?php
				if(@!$_SESSION['username']){
					echo "<span class='text-muted'>";
					echo "GUEST";
					echo "</span>";
					echo "<span class='navbar-text' id='login'>";
					echo "<a class='nav-link' href='login.php'>Login</a>";
					echo "</span>";
				} else {
					echo "<span title='Cart'><a href='cart.php'><span class='btn btn-orange nav-link bi bi-cart-fill'> " . count($_SESSION['cartBookIdArray']) . "</span></a></span> &nbsp&nbsp&nbsp&nbsp";
					echo "<span class='text-muted'>";
					echo $_SESSION['username'];
					echo "</span>";
					echo "<span class='navbar-text'>";
					echo "<a class='nav-link' href='logout.php' onclick='outFunction(username)'>Logout</a>";
					echo "</span>";
				}
			?>
		</div>
	</div>
</nav>

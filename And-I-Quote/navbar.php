<nav class="container-fluid p-3 navbar-color">
	<div class="row">
		<div class="col-6 d-flex justify-content-start">
			<a class= "nav-link text-left p-2 bar-text title-text" href="index.php">And I Quote</a>
		</div>
		<div class="col-6 d-flex justify-content-end">
			<?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true"): ?>
				<a class= "nav-link text-right p-2 bar-text" href="profile.php">Profile</a>
			<?php else: ?>
				<a class= "nav-link text-right p-2 bar-text" href="register.php">Register</a>
			<?php endif; ?>
			<?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true"): ?>
				<a class= "nav-link text-right p-2 bar-text" href="logout.php">Log Out</a>
			<?php else: ?>
			<a class= "nav-link text-right p-2 bar-text" href="login.php">Log In</a>
			<?php endif; ?>
		</div>
	</div>
</nav>

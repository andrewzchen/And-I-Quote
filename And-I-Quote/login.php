<?php
require "config/session.php";
require "navbar.php";
// if user is logged in, they shouldn't be able to reach the login page
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true") {
	header("Location: index.php");
}

if ( !isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password'])) {
	// don't continue
}
else {
	$mysqli = new mysqli(DB_host, DB_user, DB_pass, DB_db);
	if ( $mysqli->connect_errno ) {
		$error = $mysqli->connect_error;
		exit();
	}
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT *
	FROM user
	WHERE username = '" . $username . "' AND password = '" . $password . "';";
	$results = $mysqli->query($sql);
	if (!$results) {
		$error = $mysqli->error;
		exit();
	}
	if ($results->num_rows > 0) {
		var_dump($results);
		$_SESSION["logged_in"] = "true";
		$_SESSION["user"] = $username;
		$user_results = $results->fetch_assoc();
		$_SESSION["user_id"] = $user_results["user_id"];
		$_SESSION["member_level"] = $user_results["member_id"];
	//	$_SESSION["user_id"] = $results->user_id();
		header("Location: index.php");
		// Successfully found user in DB
	}
	else {
		$error = "Invalid username/password";
	}
	// check into DB with SELECT statements
	// redirect to home page
	$mysqli->close();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!-- my own stylesheet (NOT BOOTSTRAP) -->
	<link rel="stylesheet" href="basicStyle.css">
	<link rel="stylesheet" href="loginStyle.css">
</head>
<body>

  <!-- Quote of the day HARDCODED FOR NOW-->
  <div class="container-fluid align-items-center justify-content-center center-text mt-4">
	  <p class="lead quote-main">It's funny how day by day nothing changes, but when you look back everything is different.</p>
		<p class="lead quote-main">C.S. Lewis</p>
  </div>

   <div class="container login-content">
		 <div class="justify-content-center">
			<form id="loginForm" action="login.php" method="POST">
				<div class="form-group mt-5">
					<div class="col-12">
							 <input class="field-style form-control" type="text" id="username" name="username" placeholder="username">
					</div>
				</div>
				<div class="form-group mt-2">
					<div class="col-12">
							<input class="field-style form-control" type="password" id="password" name="password" placeholder="password">
					</div>
				</div>
				<div class="form-group justify-content-center center-text">
					<button type="submit" class="btn submit-btn">Log In</button>
				</div>
			</form>
			<?php if ( isset($error) && !empty($error) ) : ?>
				<div id="error" class="row mt-2 justify-content-center" style="text-align: center; color: red;"><?php echo $error ?></div>
			<?php else : ?>
				<div id="error" class="row mt-2 justify-content-center hidden" style="text-align: center; color: red;"></div>
			<?php endif; ?>
		</div>
	</div>
	<!-- JavaScript form validation: make sure login & password field aren't blank -->
	<!-- Not using a separate script file since we only need 1 JS function -->
	<script type="text/javascript">
		document.querySelector("#loginForm").onsubmit = function() {
	//		event.preventDefault();
			if (document.querySelector("#username").value.trim().length == 0 || document.querySelector("#password").value.trim().length == 0) {
				 document.querySelector("#error").innerHTML = "Error: Username and password fields cannot be blank.";
				 document.querySelector("#error").style.color = "red";
				 document.querySelector("#username").classList.add("is-invalid");
				 document.querySelector("#password").classList.add("is-invalid");
				return false;
			}
			return true;
		}
	</script>
<!-- JS that is not required by Bootstrap but required for some of
	Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

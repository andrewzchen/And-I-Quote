<?php
require "config/session.php";
require "navbar.php";
$error="";
// can't reach this page if user is logged in
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true") {
	header("Location: index.php");
}
if ( !isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password'])
 || !isset($_POST['confirm-password']) || empty($_POST['confirm-password'])) {
	 // don't continue
}
else if ($_POST['confirm-password'] != $_POST['password']) {
	// don't continue
}
else {
	// verify username is valid & add to DB
	$username = $_POST['username'];
	$password = $_POST['password'];
	$mysqli = new mysqli(DB_host, DB_user, DB_pass, DB_db);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$sql = "SELECT *
	FROM user
	WHERE username = '" . $username . "';";
	$results = $mysqli->query($sql);
	if (!$results) {
		$error = $mysqli->error;
	}
	if ($results->num_rows > 0) {
		$error = "Username already taken. Please choose another username.";
	}
	else {
		$member_level = 1;
		$sql = "INSERT INTO user(username, password, member_id)
		VALUES ('" . $username . "','" . $password . "', $member_level);";
		$results = $mysqli->query($sql);
		if (!$results) {
			$error = $mysqli->error;
			exit();
		}
		if ($results) {
			// Update session variable
			$_SESSION["logged_in"] = "true";
			$_SESSION["user"] = $username;
			// need to grab their user id
			// redirect them back to home page
			$sql = "SELECT *
			FROM user
			WHERE username = '" . $username . "';";
			$results = $mysqli->query($sql);
			if (!$results) {
				$error = $mysqli->error;
				exit();
			}
			$user_results = $results->fetch_assoc();
			$_SESSION["user_id"] = $user_results["user_id"];
			$_SESSION["member_level"] = $user_results["member_id"];
			header("Location: index.php");
		}
		$mysqli->close();
	}
}
// require statement down here, so that it loads AFTER we update session variable

//var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
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

  <!-- Quote of the day -- HARDCODED FOR NOW-->
  <div class="container-fluid align-items-center justify-content-center center-text mt-4">
	  <p class="lead quote-main">It's funny how day by day nothing changes, but when you look back everything is different.</p>
		<p class="lead quote-main">C.S. Lewis</p>
  </div>

   <div class="container-fluid login-content">
	   <div class="justify-content-center">
			<form id="registerForm" action="register.php" method="POST">
				<div class="row form-group mt-5">
          <div class="col-12">
				       <input class="field-style form-control" type="text" id="username" name="username" placeholder="username">
          </div>
				</div>
				<div class="row form-group mt-2">
          <div class="col-12">
              <input class="field-style form-control" type="password" id="password" name="password" placeholder="password">
          </div>
				</div>
        <div class="row form-group mt-2">
          <div class="col-12">
              <input class="field-style form-control" type="password" id="confirmPassword" name="confirm-password" placeholder="confirm password">
          </div>
				</div>
				<div class="form-group center-text">
					<button type="submit" class="btn submit-btn">Register</button>
				</div>
			</form>
	  </div>
		<?php if ( isset($error) && !empty($error) ) : ?>
			<div id="error" class="row mt-2 justify-content-center" style="text-align: center; color: red;"><?php echo $error ?></div>
		<?php else : ?>
			<div id="error" class="row mt-2 justify-content-center hidden" style="text-align: center; color: red;"></div>
		<?php endif; ?>
	</div>

	<!-- JavaScript form validation: make sure login & password field aren't blank -->
	<!-- Not using a separate script file since we only need 1 JS function -->
	<script type="text/javascript">
		document.querySelector("#registerForm").onsubmit = function() {
			if (document.querySelector("#username").value.trim().length == 0 || document.querySelector("#password").value.trim().length == 0
				|| document.querySelector("#confirmPassword").value.trim().length == 0) {
				 document.querySelector("#error").innerHTML = "Error: All fields must be filled out.";
				 document.querySelector("#error").style.color = "red";
	//			 document.querySelector("#error").classList.remove("hidden");
				 document.querySelector("#username").classList.add("is-invalid");
				 document.querySelector("#password").classList.add("is-invalid");
				 document.querySelector("#confirmPassword").classList.add("is-invalid");
				return false;
			}
			else if (document.querySelector("#password").value != document.querySelector("#confirmPassword").value) {
				document.querySelector("#error").innerHTML = "Error: Passwords must match.";
				document.querySelector("#error").style.color = "red";
	//			document.querySelector("#error").classList.remove("hidden");
				document.querySelector("#username").classList.add("is-invalid");
				document.querySelector("#password").classList.add("is-invalid");
				document.querySelector("#confirmPassword").classList.add("is-invalid");
				return false;
			}
	//		document.querySelector("#error").classList.add("hidden");
			// PHP -- Check DB for Username + password
			console.log(document.querySelector("#password").value);
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

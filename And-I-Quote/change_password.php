<?php
require "config/session.php";
require "navbar.php";
//var_dump($_SESSION);
// if user somehow reaches this page without being logged in, return them to index
  if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != "true") {
  //  console.log($_SESSION);
    header("Location: logout.php");
  }
  if (!isset($_POST['password']) || empty($_POST['password'])) {
  	// don't continue
  }
  else {
  	$mysqli = new mysqli(DB_host, DB_user, DB_pass, DB_db);
  	if ( $mysqli->connect_errno ) {
  		$error = $mysqli->connect_error;
  		exit();
  	}
    $username = $_SESSION["user"];
  	$password = $_POST['password'];
  	$sql = "UPDATE user
    SET password = '" . $password . "'
  	WHERE username = '" . $username . "';";
  	$results = $mysqli->query($sql);
  	if (!$results) {
  		$error = $mysqli->error;
  	   //exit();
  	}
  	if ($results) {
      $success = "Successfully updated!";
  	}
  	else {
      // realistically this hopefully shouldn't ever happen
  		$error = "Username not found.";
  	}
  	$mysqli->close();
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- my own stylesheet (NOT BOOTSTRAP) -->
  	<link rel="stylesheet" href="basicStyle.css">
    <link rel="stylesheet" href="loginStyle.css">
  </head>
  <body>
    <div class="container login-content">
 		 <div class="justify-content-center">
 			<form id="loginForm" action="change_password.php" method="POST">
 				<div class="form-group mt-2">
 					<div class="col-12">
              <label for="password">New Password:</label>
 							<input class="field-style form-control" type="password" id="password" name="password" placeholder="password">
 					</div>
 				</div>
 				<div class="form-group justify-content-center center-text">
 					<button type="submit" class="btn submit-btn">Update Password</button>
 				</div>
 			</form>
 			<?php if ( isset($error) && !empty($error) ) : ?>
 				<div id="error" class="row mt-2 justify-content-center" style="text-align: center; color: red;"><?php echo $error ?></div>
      <?php elseif ( isset($success) && !empty($success) ) : ?>
          <div id="error" class="row mt-2 justify-content-center" style="text-align: center; color: green;"><?php echo $success ?></div>
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
    console.log("fjdsaoi");
      if (document.querySelector("#password").value.trim().length == 0) {
         document.querySelector("#error").innerHTML = "Error: Password field cannot be blank.";
         document.querySelector("#error").style.color = "red";
         document.querySelector("#password").classList.add("is-invalid");
        return false;
      }
      // PHP -- Check DB for Username + password

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

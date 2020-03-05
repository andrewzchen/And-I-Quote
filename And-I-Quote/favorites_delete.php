<?php
  require "config/session.php";
  require "navbar.php";
// if user somehow reaches this page without being logged in, return them to index
  if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != "true") {
  //  console.log($_SESSION);
    header("Location: logout.php");
  }
// Add the quote to favorites
$mysqli = new mysqli(DB_host, DB_user, DB_pass, DB_db);
if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_error;
  exit();
}
$sql = "DELETE FROM fav_quotes
  WHERE quotes_id = " . $_GET["quotes_id"] . ";";
$results = $mysqli->query($sql);
if (!$results) {
  echo $mysqli->error;
  exit();
}
if ($results) {
  // insert successful, go back to page
  $isDeleted = "true";
}
$mysqli->close();
// $sql = "INSERT INTO user(username, password, member_id)
// VALUES ('" . $username . "','" . $password . "', $member_level);";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete a Quote</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- my own stylesheet (NOT BOOTSTRAP) -->
    <link rel="stylesheet" href="basicStyle.css">
  </head>
  <body>

<div class="container">
		<div class="row mt-3">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>

				<div class="text-danger font-italic">
					<?php echo $error; ?>
				</div>
			<?php endif; ?>
			<?php if ($isDeleted) : ?>
				<div class="text-success">The quote was successfully deleted.</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="favorites.php" role="button" class="btn btn-primary">Back to Favorites</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>

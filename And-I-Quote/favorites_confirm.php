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
  $error = $mysqli->connect_error;
  exit();
}
$user_id = $_SESSION["user_id"];
$member_id = $_SESSION["member_level"];
// sometimes API returns quotes with garbage characters that mess up INSERT
$quote = $mysqli->real_escape_string($_GET["quote"]);
$sql = "INSERT INTO fav_quotes(quote, user_id, user_member_id)
  VALUES ('" . $quote . "', $user_id, $member_id);";
$results = $mysqli->query($sql);
if (!$results) {
  $error =  $mysqli->error;
}
if ($results) {
  $isAdded = "true";
}
$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add to Favorites</title>
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
			<?php if (isset($isAdded) && $isAdded) : ?>
				<div class="text-success">The quote
				was successfully added to your favorites. To view your favorites, go to Profile -> View Favorites.</div>
			<?php endif; ?>
			</div>
		</div>
		</div>
	</div>
</body>
</html>

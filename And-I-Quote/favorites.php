<?php
require "config/session.php";
require "navbar.php";
// if user somehow reaches this page without being logged in, return them to index
  if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != "true") {
  //  console.log($_SESSION);
    header("Location: logout.php");
  }
  $mysqli = new mysqli(DB_host, DB_user, DB_pass, DB_db);
  if ( $mysqli->connect_errno ) {
    $error = $mysqli->connect_error;
    exit();
  }
  $user_id = $_SESSION["user_id"];

  $sql = "SELECT *
  FROM fav_quotes
  WHERE user_id = $user_id;";
  $results = $mysqli->query($sql);
  $count = 0;
  $member_level = 1;
//  var_dump($results);
  if (!$results) {
    $error = $mysqli->error;
    exit();
  }
  // check into DB with SELECT statements
  // redirect to home page
  $mysqli->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Favorites</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- my own stylesheet (NOT BOOTSTRAP) -->
    <link rel="stylesheet" href="basicStyle.css">
  </head>
  <body>
    <div class="container">
    <?php while( $row = $results->fetch_assoc() ): ?>
        <?php $member_level = $row["user_member_id"];?>
        <?php if (($member_level == 1) && $count > 1) { // FREE members can only see 2 favorite quotes
          break;
        }
        ?>
        <div class="row">
          <div class="col-10">
            <li class="text-left"><?php echo $row["quote"]; ?></li>
            </div>
          <div class="col-2">
            <a class="btn btn-primary profileBtn" href="favorites_delete.php?quotes_id=<?php echo $row["quotes_id"]; ?>">Delete</a>
          </div>
        </div>
        <br />
        <br />
        <?php $count = $count + 1; ?>
    <?php endwhile; ?>
    <?php if (($count > 1) && ($member_level == 1)): ?>
    <strong> To see more than 2 of your favorite quotes, you must be a premium member. To upgrade, email chen901@usc.edu
      for consideration.</strong>
    <?php elseif ($count == 0) : ?>
    <strong> You currently have no favorite quotes!</strong>
    <?php endif; ?>
    </div>
    <!-- JS that is not required by Bootstrap but required for some of
      Bootstrap -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

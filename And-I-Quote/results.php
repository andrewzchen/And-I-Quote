<?php
require "config/session.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Font Awesomeimport this for the heart icon  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- my own stylesheet (NOT BOOTSTRAP) -->
  <link rel="stylesheet" href="basicStyle.css">
	<link rel="stylesheet" href="resultsStyle.css">
</head>
<body>

<!-- Add the search text field onto our top navigation bar -->
<nav class="container-fluid p-3 navbar-color">
	<div class="row">
		<div class="order-2 order-md-1 col-6 col-md-3">
			<a class= "nav-link text-left p-2 bar-text title-text" href="index.php">And I Quote</a>
    </div>
    <div class="order-1 order-md-2 col-12 col-md-5">
      <form action="results.php" id="searchForm" method="GET">
        <div class="form-group row mt-2">
          <div class="col-9">
            <input class="field-style form-control searchField" type="text" name="search" id="search" value= <?php echo $_GET['search'];?> >
          </div>
          <div class="col-3 mt-1">
            <input type="image" class="search-image" name="submit" src="images/search_icon.jpg" >
          </div>
        </div>
      </form>
    </div>
    <div class="order-3 col-6 col-md-4 d-flex justify-content-end">
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

<!-- Display search results in columns -->
<div class="container-fluid">
  <p class="lead"></p>
  <br />
  <div class="row resultRow">
    <div class="col-11">
      <p class="lead" id="quote"></p>
    </div>
		<div class="col-1">
			<i class="fas fa-heart"></i>
		</div>
  </div>
</div>

<!-- JavaScript form validation: make sure search field isn't blank -->
<!-- Not using a separate script file since we only need 1 JS function -->
<script type="text/javascript">
	document.querySelector("#searchForm").onsubmit = function() {
		if (document.querySelector("#search").value.trim().length == 0) {
			 document.querySelector("#search").style.borderColor = "red";
			return false;
		}
 		 randomQuoteCall(document.querySelector("#search").value);
		return true;
	}
</script>

<!-- JS that is not required by Bootstrap but required for some of
	Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- jQuery -->
	<script
	src="http://code.jquery.com/jquery-3.4.1.min.js"
	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	crossorigin="anonymous"></script>
	<!-- Script file for the API we are using  -->
	<script src="scripts/WikiQuoteApi.js"></script>
	<!-- Script file that actually calls our API, places info inside our rows -->
	<script src="scripts/searchScript.js"></script>
</body>
</html>

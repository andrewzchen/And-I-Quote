<?php
require "config/session.php";
require "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>And I Quote</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


	<!-- my own stylesheet (NOT BOOTSTRAP) -->
  <link rel="stylesheet" href="basicStyle.css">
	<link rel="stylesheet" href="homeStyle.css">
</head>
<body>

  <!-- Quote of the day  HARDCODED FOR NOW-->
  <div class="container-fluid align-items-center justify-content-center center-text mt-4">
	  <p class="lead quote-main">It's funny how day by day nothing changes, but when you look back everything is different.</p>
		<p class="lead quote-main">C.S. Lewis</p>
  </div>
  <div class="adjust-height flex align-items-center center-text">
    <div class="container search-container">
        <div class="justify-content-center">
          <div class="col-12">
            <p></p>
          </div>
        <form id="searchForm" action="results.php" method="GET">
          <div class="form-group row mt-4">
            <div class="col-9">
              <input class="field-style form-control" type="text" id="search" name="search" placeholder="search by keyword, tag, or author">
            </div>
            <div class="col-2">
              <input type="image" class="search-image" name="submit" src="images/search_icon.jpg" >
            </div>
          </div>
        </form>
        </div>
				<div id="error" class="row mt-2 justify-content-center hidden" style="text-align: center;"></div>
    </div>
  </div>

	<!-- JavaScript form validation: make sure search field isn't blank -->
	<!-- Not using a separate script file since we only need 1 JS function -->
	<script type="text/javascript">
		document.querySelector("#searchForm").onsubmit = function() {
	//		event.preventDefault();
			if (document.querySelector("#search").value.trim().length == 0) {
				// document.querySelector("#error").innerHTML = "Error: Search field cannot be blank.";
				// document.querySelector("#error").style.color = "red";
				 document.querySelector("#search").style.borderColor = "red";
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

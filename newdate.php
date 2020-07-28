<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->



<!DOCTYPE html>
<!-- Used Bootstrap documentation as source -->
<html lang="en">
<head>
  <meta charset="utf-8">

 <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>New Birthday</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />

  <style>
	.error{color: red; font-style: italic; padding: 5px;}
	.nav-link {
		color: white;
	}
	.col-md-auto{font-size: 30px;}
	.col-lg-2{font-size: 24px;}
	.col-lg-4{font-size: 24px;}

	/* The popup form - hidden by default */
	.form-popup {
	  display: none;
	  position: absolute;
	  left: 50%;
	  top: 38%;
	  transform: translate(-50%, -50%);
	  border: 3px solid black;
	  background-color: white;
	}

	.form-container {
		max-width: 800px;
		max-height: 800px;
		padding: 10px;
		background-color: white;
	}

  </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$(function(){
		$("#header").load("navbar_header.html");
		});
	</script>
</head>

<!-- Header and first screen with options to create/modify existing -->
<body>
	<div id="header"></div>
	<div class = "container">
		<div class= "text-center">
			<br>
			<h1>New Birthday Form<h1>
			<hr/>
		</div>
	</div>
	<br>
    <div class="container" id="firstScreen">
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <button type="button" id="change_user" class="btn btn-block btn-primary btn-lg" onclick="changeExisting()">Modify Existing Birthday</button>
            </div>
            <div class="col col-lg-2">
            </div>
        	<div class="col col-lg-4">
        		<button type="button" id="change_user" class="btn btn-block btn-primary btn-lg" onclick="createNewOption()" >Create Contact</button>
        	</div>
        </div>
        <br><br>
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <button type="button" id="change_user" class="btn btn-block btn-danger btn-lg" onclick="delete1()">Delete Contact</button>
            </div>
        </div>
        <br><br>
   </div>

      <script>

          //"Modify existing option" listener. Goes to name search form
          function changeExisting(){
                  document.location='findContact.php';
          }

          //"Create new contact" option listener. Goes to new contact form
          function createNewOption(){
              document.location='createContact.php';
          }

          //"Delete contact" option listener. Goes to delete name search form
          function delete1(){
              document.location='deletionFinder.php';
          }

     </script>

</body>
</html>

<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php
    session_start();
    require("load_user_db.php");

    $user=$_SESSION['user'];
    $currentcontact=$_SESSION['contactname'];

    $dateInputError="";
    $successMsg="";

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $query="DELETE FROM $user WHERE Name=:c_name";
        $statement=$db->prepare($query);
        $statement->bindValue(':c_name', $currentcontact);
        $statement->execute();
        $statement->closeCursor();
        $successMsg="Successfully deleted contact with name ".$currentcontact.". Redirecting to home in 5 seconds";
    }

?>

<!DOCTYPE html>
<!-- Used Bootstrap documentation as source -->
<html lang="en">
<head>
  <meta charset="utf-8">

 <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Delete Contact</title>

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
			<h1>Delete Contact<h1>
			<hr/>
		</div>
	</div>
	<br>

  <!-- Now that name is found we can edit the birthday -->
   <div class="container" id="namefound">
       <div class="row justify-content-md-center">
           <div class="col col-lg-4">
               <div class= "text-left" id="currentdate"><p >Contact to Delete:</p></div>
           </div>
           <div class="col col-lg-2">
               <div class= "text-left" id="currBday"><p ><?php echo $currentcontact;?></p></div>
           </div>
           <div class="col col-lg-2">
           </div>
       </div>
       <br><br>
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
               <div class="col">
                   <button name="deleteBtn" type="submit" id="deleteBtn" class="btn btn-block btn-danger btn-lg">Delete Contact</button>
                   <br><br>
                   <button type="button" id="back" class="btn btn-primary btn-lg" >Back</button>
               </div>
           </div>
           <p class="text-md-center text-success" id="successmessage"><?php echo $successMsg;?></p>
       </form>
  </div>



      <script>

      //Execute after deletion successful
      if(document.getElementById("successmessage").innerHTML!=""){
          document.getElementById("deleteBtn").disabled=true;
          document.getElementById("back").disabled=true;
          setTimeout(() => {document.location='home.php';} ,5000)
      }

      document.getElementById("back").addEventListener('click', function() {
          document.location='deletionFinder.php';
      });
     </script>

 </body>
</html>

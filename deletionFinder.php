<?php
session_start();

$nameresult="";
$noneFoundError="";
if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['contactname']) > 0)
{
    require("load_user_db.php");
    $contact = trim($_POST['contactname']);

    $user=$_SESSION['user'];
    $query = "SELECT * FROM $user WHERE Name='$contact'";

    //$query = "SELECT * FROM loganhylton99 WHERE Name='$contact'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    if (strlen($result['Name']) > 0){
        $nameresult=$result['Name'];
        $noneFoundError="";
        $_SESSION['contactname'] = $nameresult;
        header('Location: deleteContact.php');
    }else{
        $noneFoundError="<br>Could not find contact with name \"".$contact."\" in your contact book. <br> Please search again or click \"Add New Birthday\" to create a new contact";
    }
}

?>

<!DOCTYPE html>
<!-- Used Bootstrap documentation as source -->
<html lang="en">
    <head>
      <meta charset="utf-8">

     <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Find Contact</title>

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
        			<h1>Search for Contact to Modify<h1>
        			<hr/>
        		</div>
        	</div>
        	<br>

        <!-- CHANGING EXISTING BIRTHDAY -->
        <!-- First search contacts for name given as input -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="container" id="searchName">
                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">
                      <div class= "text-right"><p >Contact Name:</p></div>
                    </div>
                    <div class="col col-lg-4">
                      <input name="contactname" type="text" class="form-control" id="contactnamecheck">
                    </div>
                  <div class="col col-lg-3">
                      <button name="checkContacts" type="submit" id="change_user" class="btn btn-block btn-success btn-lg" onClick="checkName()">Check Contacts</button>
                  </div>
                </div>
                <p class="text-md-center text-danger" id="nocontactfounderror"><?php echo $noneFoundError;?></p>
                <br><br>
           </div>
        </form>
    </body>
</html>

<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php
    session_start();
    require("load_user_db.php");

    $user=$_SESSION['user'];
    $currentcontact=$_SESSION['contactname'];
    //get current birthday
    $query = "SELECT * FROM $user WHERE Name='$currentcontact'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    $currentDate= $result["Birthday"];

    //format date
    // Formatting date help from https://www.tutorialrepublic.com/
    $timestamp = strtotime($currentDate);
    $formatted_date = date("m-d-Y", $timestamp);
    $currentDate= $formatted_date;

    $dateInputError="";
    $successMsg="";

    if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['newBday']) > 0)
    {
        require("load_user_db.php");
        //get inputted birthday
        $newBirthday = trim($_POST['newBday']);
        if(strlen($newBirthday)!=10){
            $successMsg="";
            $dateInputError="Please enter a valid date in the format MM/DD/YYY";
        }else{
            $dateInputError="";
            // Formatting date help from https://www.tutorialrepublic.com/
            $timestamp = strtotime($newBirthday);
            $formatted_date = date("Y-m-d", $timestamp);
            $newBirthday= $formatted_date;

            //Update birthday in db
            $query="UPDATE $user SET Birthday=:c_bday WHERE Name=:c_name";
            $statement= $db->prepare($query);
            $statement->bindValue(':c_name', $currentcontact);
            $statement->bindValue(':c_bday', $newBirthday);
            $statement->execute();
            $statement->closeCursor();

            //update current birthday
            $query = "SELECT * FROM $user WHERE Name='$currentcontact'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();
            $statement->closeCursor();
            $currentDate= $result["Birthday"];
            // Formatting date help from https://www.tutorialrepublic.com/
            $timestamp = strtotime($currentDate);
            $formatted_date = date("m-d-Y", $timestamp);
            $currentDate= $formatted_date;

            $successMsg=$currentcontact."'s birthday successfully changed to ".$currentDate."<br> Click \"Done\" to return home or enter a new date.";
        }
    }

?>



<!DOCTYPE html>
<!-- Used Bootstrap documentation as source -->
<html lang="en">
<head>
  <meta charset="utf-8">

 <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Change Contact Birthday</title>

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
			<h1>Change existing contact birthday<h1>
			<hr/>
		</div>
	</div>
	<br>

  <!-- Now that name is found we can edit the birthday -->
   <div class="container" id="namefound">
       <div class="row justify-content-md-center">
           <div class="col col-lg-4">
               <div class= "text-left" id="currentdate"><p >Current Date:</p></div>
           </div>
           <div class="col col-lg-2">
               <div class= "text-left" id="currBday"><p ><?php echo $currentDate;?></p></div>
           </div>
           <div class="col col-lg-2">
           </div>
       </div>
       <br><br>
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
           <div class="row justify-content-md-center">
               <div class="col col-lg-2">
                   <div class= "text-left"><p>New Date:</p></div>
               </div>
               <div class="col col-lg-4">
                   <!-- <input name="newBday" type="date" class="form-control" id="newdate" placeholder="MM/DD/YYYY" onkeypress="return inputlength(event)"> -->
                   <input name="newBday" type="date" class="form-control" id="newdate" placeholder="MM/DD/YYYY">
               </div>
               <div class="col col-lg-3">
                   <button name="changeBday" type="submit" id="change_date" class="btn btn-block btn-primary btn-lg">Update Current Date</button>
               </div>
           </div>
           <p class="text-md-center text-danger" id="invaliddaterror1"><?php echo $dateInputError;?></p>
           <p class="text-md-center text-success" id="nocontactfounderror"><?php echo $successMsg;?></p>
           <br><br>
           <button type="button" id="done" class="btn btn-block btn-primary btn-lg">Done</button>
       </form>
  </div>



      <script>

          // //Stops user from entering invalid date length, or invalid chars in date inputs
          // function inputlength(event){
          //     var charCode = event.keyCode;
          //     date=document.getElementById("newdate").value;
          //     if((date.length==10 && charCode!=8) || (charCode<47 && charCode!=8) || charCode>57){
          //         return false;
          //     }else{
          //         return true;
          //     }
          // }

         //Done button at end of modify screen to return to home page
         document.getElementById("done").addEventListener('click', function() {
             document.location='home.php';
         });
     </script>

 </body>
</html>

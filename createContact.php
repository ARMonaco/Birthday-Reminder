<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php
    session_start();
    require("load_user_db.php");

    $user=$_SESSION['user'];
    $nameerror="";
    $dateInputError="";
    $successMsg="";
    if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['bday']) > 0 && strlen($_POST['name']) > 0)
    {
        require("load_user_db.php");
        $contactname=trim($_POST['name']);
        $contactbday = trim($_POST['bday']);
        $email=0;
        $text=0;
        $desktop=0;
        //get check boxes
        if (isset($_POST['email'])) {
            $email=1;
        }
        if (isset($_POST['text'])) {
            $text=1;
        }
        if (isset($_POST['desktop'])) {
            $desktop=1;
        }
        if(strlen($contactbday)!=10){
            $dateInputError="Please enter a valid date in the format MM/DD/YYY";
            $successMsg="";
        }
        else{
            $dateInputError="";
            // Formatting date help from https://www.tutorialrepublic.com/
            $timestamp = strtotime($contactbday);
            $formatted_date = date("Y-m-d", $timestamp);
            $contactbday= $formatted_date;

            //check if contact name already exists
            $query = "SELECT * FROM $user WHERE Name='$contactname'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();
            $statement->closeCursor();
            if($result!=null){
                $nameerror="Contact already exists for ".$contactname."<br> To modify birthday, click \"Add New Birthday\" in the toolbar, or enter a different name to create contact.";
                $successMsg="";
            }
            else{
                $query= "INSERT INTO $user (Name, Birthday, Email, SMS, Desk) VALUES (:c_name, :c_bday, :c_email, :c_text, :c_desktop)";
                $statement= $db->prepare($query);

                //bind form data to query values before insert
                $statement->bindValue(':c_name', $contactname);
                $statement->bindValue(':c_bday', $contactbday);
                $statement->bindValue(':c_email', $email);
                $statement->bindValue(':c_text', $text);
                $statement->bindValue(':c_desktop', $desktop);

                $result=$statement->execute(); //execute returns a statement which could be error if unsuccessful
                if(!$result){ //if error
                    print_r($statement->errorInfo());
                    exit;
                }
                $statement->closeCursor();
                $successMsg="Successfully created contact with name ".$contactname.". Redirecting to home in 5 seconds";
            }
        }
    }

?>


<!DOCTYPE html>
<!-- Used Bootstrap documentation as source -->
<html lang="en">
<head>
  <meta charset="utf-8">

 <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Create Contact</title>

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
			<h1>New Contact Form<h1>
			<hr/>
		</div>
	</div>
	<br>

  <!-- CREATING NEW CONTACT -->
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="container" id="creatingnew">
          <div class="row justify-content-md-center">
              <div class="col col-lg-2">
                  <div class= "text-left"><p>Name:</p></div>
              </div>
              <div class="col col-lg-4">
                <input name="name" type="text" class="form-control" id="newcontactname" onkeyup="enabler()">
              </div>
              <div class="col col-lg-3">
              </div>
          </div>
          <p class="text-md-center text-danger" id="nonamerror"><?php echo $nameerror;?></p>
          <br>
          <div class="row justify-content-md-center">
              <div class="col col-lg-2">
                  <div class= "text-left"><p>Birthday:</p></div>
              </div>
              <div class="col col-lg-4">
                  <input name="bday"class="form-control" type="date" id="contactbday" placeholder="MM/DD/YYYY" onkeypress="return inputlength(event)" onkeyup="enabler()">
              </div>
              <div class="col col-lg-3">
              </div>
          </div>
          <p class="text-md-center text-danger" id="invaliddaterror2"><?php echo $dateInputError;?></p>
          <br>
          <div class="row justify-content-md-center">
              <div class="col col-lg-2">
                  <div class= "text-left"><p>Notification Settings:</p></div>
              </div>
              <div class="col col-lg-4">
                  <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input name="email" class="form-check-input" type="checkbox" id="email"> Email
                      </label>
                  </div>
                  <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input name="text"  class="form-check-input" type="checkbox" id="text"> Text
                      </label>
                  </div>
                  <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input name="desktop" class="form-check-input" type="checkbox" id="desktop"> Desktop Notification
                      </label>
                  </div>
               </div>
              <div class="col col-lg-3">
              </div>
          </div>
          <br><br>
          <button type="submit" id="createBtn" class="btn btn-block btn-success btn-lg" disabled=true>Create New Contact</button>
          <br>
          <p class="text-md-center text-success" id="successmessage"><?php echo $successMsg;?></p>
          <br><br>
          <button type="button" id="back" class="btn btn-primary btn-lg" >Back</button>
      </div>
  </form>

  <script>

        if(document.getElementById("successmessage").innerHTML!=""){
            document.getElementById("newcontactname").disabled=true;
            document.getElementById("contactbday").disabled=true;
            document.getElementById("back").disabled=true;
            setTimeout(() => {document.location='home.php';} ,5000)
        }

        document.getElementById("newcontactname").focus();

        function enabler(){
            date=document.getElementById("contactbday").value;
            name=document.getElementById("newcontactname").value;
            if(date.length>0 && name.length>0){
                document.getElementById("createBtn").disabled=false;
            } else{
                document.getElementById("createBtn").disabled=true;
            }
        }

        // //Stops user from entering invalid date length, or invalid chars in date inputs
        // function inputlength(event){
        //     var charCode = event.keyCode;
        //     date=document.getElementById("contactbday").value;
        //     if((date.length==10 && charCode!=8) || (charCode<47 && charCode!=8) || charCode>57){
        //         return false;
        //     } else{
        //         return true;
        //     }
        // }

        document.getElementById("back").addEventListener('click', function() {
            document.location='newdate.php';
        });
 </script>

</body>
</html>

<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php session_start(); // make sessions available ?>
<?php

if (!isset($_SESSION['user']))//kicks user out if not logged in
{
	header('Location: signin.php?error=notloggedin');
}


function error_msg($error) //prints error message dependant on URL
{
	$msg = "";
	switch($error){
		case "usertaken":
			$msg = "Username taken. Please try again.";
			break;
		case "usershort":
			$msg = "Username too short. Please try again.";
			break;
		case "passshort":
			$msg = "Password too short. Please try again.";
			break;
		case "phoneshort":
			$msg = "Phone number too short. Please try again.";
			break;
		case "emailshort":
			$msg = "Email too short. Please try again.";
			break;
		case "emailtaken":
			$msg = "Email was taken. Please try again.";
			break;
	}
	echo "<script>alert('$msg');</script>";
}

if( isset($_GET["error"])){ //checks for error in URL
	error_msg($_GET["error"]);
}




if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["action"] == "delete") //delete account request
{
	require("load_user_db.php");
	$user = $_SESSION['user'];
	$query = "DELETE FROM `user_info` WHERE username='$user'";
	$statement = $db->prepare($query);
	$statement->execute();
	$statement->closeCursor();
	
	$query2 = "DROP TABLE $user";
	$statement2 = $db->prepare($query2);
	$statement2->execute();
	$statement2->closeCursor();
	
	foreach ($_SESSION as $key => $value)
	{ 	
		unset($_SESSION[$key]);      
	}       
	session_destroy();
   
	header('Location: signin.php');
	
}else if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["action"] == "changeuser") // change username request
{
	require("load_user_db.php");
	$newuser = trim($_POST['userentry']);
	$current_user = $_SESSION['user'];
	$email_user = $_SESSION['email'];
	
	$query = "SELECT * FROM user_info WHERE username='$newuser'";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	
	if (strlen($result['username']) > 0){
		header('Location: profile.php?error=usertaken');
		
	}else if(strlen($newuser) < 5){
		header('Location: profile.php?error=usershort');
	}else{
		$query = "ALTER TABLE $current_user RENAME TO $newuser";
		$statement = $db->prepare($query);
		$statement->execute();
		$statement->closeCursor();
		
		$_SESSION['user'] = $newuser;
		
		$query2 = "UPDATE user_info SET username=:newuser WHERE email=:email_user";
	
		$statement2 = $db->prepare($query2);
	
		$statement2->bindValue(':newuser', $newuser);
		$statement2->bindValue(':email_user', $email_user);
	
		$statement2->execute();
	
		$statement2->closeCursor();
		
	}
}else if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["action"] == "changepass") // change username request
{
	require("load_user_db.php");
	$newpass = trim($_POST['passentry']);
	$current_pass = $_SESSION['pwd'];
	$email_user = $_SESSION['email'];
	
	if(strlen($newpass) < 8){
		header('Location: profile.php?error=passshort');
	}else{
		$_SESSION['pwd'] = $newpass;
		
		$query2 = "UPDATE user_info SET password=:newpass WHERE email=:email_user";
	
		$statement2 = $db->prepare($query2);
	
		$statement2->bindValue(':newpass', $newpass);
		$statement2->bindValue(':email_user', $email_user);
	
		$statement2->execute();
	
		$statement2->closeCursor();
	}
	
}else if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["action"] == "changephone") //change phone number request
{
	require("load_user_db.php");
	$newphone = trim($_POST['phoneentry']);
	$current_phone = $_SESSION['phone'];
	$email_user = $_SESSION['email'];
	
	if(strlen($newphone) < 7){
		header('Location: profile.php?error=phoneshort');
	}else{
		$_SESSION['phone'] = $newphone;
		
		$query2 = "UPDATE user_info SET phone=:newphone WHERE email=:email_user";
	
		$statement2 = $db->prepare($query2);
	
		$statement2->bindValue(':newphone', $newphone);
		$statement2->bindValue(':email_user', $email_user);
	
		$statement2->execute();
	
		$statement2->closeCursor();
	}
	
}else if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["action"] == "changeemail") // change email request
{
	require("load_user_db.php");
	$newemail = trim($_POST['emailentry']);
	$current_email = $_SESSION['email'];
	$user = $_SESSION['user'];
	
	
	$query = "SELECT * FROM user_info WHERE email='$current_email'";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	
	if (strlen($result['email']) > 0){
		header('Location: profile.php?error=emailtaken');
		
	}
	
	else if(strlen($newemail) < 10){
		header('Location: profile.php?error=emailshort');
	}else{
		$_SESSION['email'] = $newemail;
		
		$query2 = "UPDATE user_info SET email=:newemail WHERE username=:user";
	
		$statement2 = $db->prepare($query2);
	
		$statement2->bindValue(':newemail', $newemail);
		$statement2->bindValue(':user', $user);
	
		$statement2->execute();
	
		$statement2->closeCursor();
	}
}
?>

<html lang="en">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Birthday Reminder Profile</title>    
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" /> 
	<link rel="stylesheet" href="main.css" /> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<!-- loads navbar header -->
	<script> 
	$(function(){
		$("#header").load("navbar_header.html"); 
		});
	</script>  
	
	
</head>



<body>

<!-- Profile Settings header at top of page -->
<div id="header"></div>
	<div class = "container">
		<div class= "text-center">
			<br>
			<h1>Profile Settings<h1>
			<hr/>
		</div>
	</div>
<br>
	
<!-- main container for page -->
<div class="container">

	<!-- username row -->
	<div class="row justify-content-md-center">
		<div class="col col-lg-2">
			<div class= "text-right"><p id="user_label">Username:</p></div>
		</div>
		<div class="col col-lg-4">
			<p id="user_text"><?php echo $_SESSION['user'];?></p>
		</div>
		<div class="col col-lg-3">
			<button type="button" id="change_user" class="btn btn-block btn-primary btn-lg">Change Username</button>
		</div>

	</div>
  
	<br><br>
	<!-- email row -->
	<div class="row justify-content-md-center">
		<div class="col col-lg-2">
			<div class= "text-right"><p id="email_label">Email:</p></div>
		</div>
		<div class="col col-lg-4">
		  <p id="email_text"><?php echo $_SESSION['email'];?></p>
		</div>
		<div class="col col-lg-3">
			<button type="button" id="change_email" class="btn btn-block btn-primary btn-lg">Change Email</button>
		</div>
	</div>
	<br><br>
	
	<!-- password row -->
	<div class="row justify-content-md-center">
		<div class="col col-lg-2">
			<div class= "text-right"><p id="pass_label">Password:</p></div>
		</div>
		<div class="col col-lg-4">
		  <p id="pass_text"><?php echo $_SESSION['pwd'];?></p>
		</div>

		<div class="col col-lg-3">
			<button type="button" id="change_password" class="btn btn-block btn-primary btn-lg">Change Password</button>
		</div>

	</div>
	<br><br>
	
	
	<!-- phone number row -->
	<div class="row justify-content-md-center">
		<div class="col col-lg-2">
			<div class= "text-right"><p id="phone_label">Phone #:</p></div>
		</div>
		<div class="col col-lg-4">
		  <p id="phone_text"><?php echo $_SESSION['phone'];?></p>
		</div>
		
		<div class="col col-lg-3">
			<button type="button" id="change_phone" class="btn btn-block btn-primary btn-lg">Change Phone #</button>
		</div>
	</div>
	<hr/>
</div>


<!-- delete account button -->
<div class="container">
	<br>
	<div class="row justify-content-md-center">
		<div class="col col-lg-4">
		<form id="delete_form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="submit" id="delete_account" class="btn btn-block btn-danger btn-lg" value="DELETE ACCOUNT">
			<input name="action" value="delete" hidden>
		</div>
		</form>
	</div>
</div>


<!-- username change form -->
<div class="form-popup" id="user_form">
	<div class="form-container">
		<h1>Change Username</h1>

		<label for="new_user"><b>New Username:</b></label>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="change_user_form" method="post">
			<input type="text" class="form-control" name="userentry" id="userentry">
			<input type="submit" id="change_user_confirm" class="btn btn-block btn-primary btn-lg" value="Change Username">
			<input name="action" value="changeuser" hidden>
		</form>
		<button type="button" id="user_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</div>

</div>


<!-- password change form -->
<div class="form-popup" id="pass_form">
	<div class="form-container">
		<h1>Change Password</h1>

		<label for="new_user"><b>New Password:</b></label>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="change_pass_form" method="post">
			<input type="text" class="form-control" name="passentry" id="passentry">
			<input type="submit" id="change_pass_confirm" class="btn btn-block btn-primary btn-lg" value="Change Password">
			<input name="action" value="changepass" hidden>
		</form>
		<button type="button" id="pass_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</div>
</div>

<!-- email change form -->
<div class="form-popup" id="email_form">
	<div class="form-container">
		<h1>Change Email</h1>

		<label for="new_user"><b>New Email:</b></label>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="change_email_form" method="post">
			<input type="text" class="form-control" name="emailentry" id="emailentry">
			<input type="submit" id="change_email_confirm" class="btn btn-block btn-primary btn-lg" value="Change Email">
			<input name="action" value="changeemail" hidden>
		</form>
		<button type="button" id="email_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</div>
</div>


<!-- phone change form -->
<div class="form-popup" id="phone_form">
	<div class="form-container">
		<h1>Change Phone</h1>

		<label for="new_user"><b>New Phone #:</b></label>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="change_phone_form" method="post">
			<input type="text" class="form-control" name="phoneentry" id="phoneentry">
			<input type="submit" id="change_phone_confirm" class="btn btn-block btn-primary btn-lg" value="Change Phone">
			<input name="action" value="changephone" hidden>
		</form>
		<button type="button" id="phone_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	
</div>


<script>
	
	<!-- gets the buttons -->
	var user_button = document.getElementById("change_user");
	var email_button = document.getElementById("change_email");
	var pass_button = document.getElementById("change_password");
	var phone_button = document.getElementById("change_phone");
	
	<!-- USERNAME BUTTON SECTION -->
	<!-- username button click -->
	user_button.onclick = function(){
		document.getElementById("user_form").style.display = "block";
		disable_buttons();
	}
	<!-- username form submit validation -->
	var user_form_submit = document.getElementById("change_user_confirm");
	user_form_submit.onclick = function(){
		var entry = document.getElementById("user_entry").value;
		var user_text = document.getElementById("user_text");
		if(entry.length == 0){
			window.alert("Please input a value for the username.");
		}else{
			user_text.innerHTML = entry;
			document.getElementById("user_entry").value = '';
			document.getElementById("user_form").style.display = "none";
			enable_buttons();
		}
		
	}
	<!-- username form close button -->
	var user_form_close = document.getElementById("user_form_close_btn");
	user_form_close_btn.onclick = function(){
		document.getElementById("user_form").style.display = "none";
		enable_buttons();
	}
	
	<!-- ------------------------------------------------------------------ -->
	
	<!-- EMAIL BUTTON SECTION -->
	<!-- email button click -->
	email_button.onclick = function(){
		document.getElementById("email_form").style.display = "block";
		disable_buttons();
	}
	<!-- email form submit validation -->
	var email_form_submit = document.getElementById("change_email_confirm");
	email_form_submit.onclick = function(){
		var entry = document.getElementById("email_entry").value;
		var email_text = document.getElementById("email_text");
		if(entry.length == 0){
			window.alert("Please input a value for the email.");
		}else{
			email_text.innerHTML = entry;
			document.getElementById("email_entry").value = '';
			document.getElementById("email_form").style.display = "none";
			enable_buttons();
		}
		
	}
	<!-- email form close button -->
	var email_form_close = document.getElementById("email_form_close_btn");
	email_form_close_btn.onclick = function(){
		document.getElementById("email_form").style.display = "none";
		enable_buttons();
	}
	
	<!-- ------------------------------------------------------------------ -->
	
	<!-- PASSWORD BUTTON SECTION -->
	<!-- change password button click -->
	pass_button.onclick = function(){
		document.getElementById("pass_form").style.display = "block";
		disable_buttons();
	}
	<!-- password form submit validation -->
	var pass_form_submit = document.getElementById("change_pass_confirm");
	pass_form_submit.onclick = function(){
		var entry = document.getElementById("pass_entry").value;
		var user_text = document.getElementById("pass_text");
		if(entry.length == 0){
			window.alert("Please input a value for the password.");
		}else{
			pass_text.innerHTML = entry;
			document.getElementById("pass_entry").value = '';
			document.getElementById("pass_form").style.display = "none";
			enable_buttons();
		}
		
	}
	<!-- password form close button -->
	var pass_form_close = document.getElementById("pass_form_close_btn");
	pass_form_close_btn.onclick = function(){
		document.getElementById("pass_form").style.display = "none";
		enable_buttons();
	}
	
	<!-- ------------------------------------------------------------------ -->
	
	<!-- PHONE BUTTON SECTION -->
	<!-- phone button click -->
	phone_button.onclick = function(){
		document.getElementById("phone_form").style.display = "block";
		disable_buttons();
	}
	<!-- phone form validation -->
	var phone_form_submit = document.getElementById("change_phone_confirm");
	phone_form_submit.onclick = function(){
		var entry = document.getElementById("phone_entry").value;
		var user_text = document.getElementById("phone_text");
		if(entry.length == 0){
			window.alert("Please input a value for the phone.");
		}else{
			phone_text.innerHTML = entry;
			document.getElementById("phone_entry").value = '';
			document.getElementById("phone_form").style.display = "none";
			enable_buttons();
		}
		
	}
	<!-- phone form close button -->
	var phone_form_close = document.getElementById("phone_form_close_btn");
	phone_form_close_btn.onclick = function(){
		document.getElementById("phone_form").style.display = "none";
		enable_buttons();
	}
	
	<!-- ------------------------------------------------------------------ -->
	<!-- ------------------------------------------------------------------ -->
	<!-- ------------------------------------------------------------------ -->
	
	<!-- FUNCTION THAT DISABLES BUTTONS -->
	function disable_buttons(){
		$(user_button).prop('disabled', true);
		$(email_button).prop('disabled', true);
		$(pass_button).prop('disabled', true);
		$(phone_button).prop('disabled', true);
	}
	
	<!-- FUNCTION THAT ENABLES BUTTONS -->
	function enable_buttons(){
		$(user_button).prop('disabled', false);
		$(email_button).prop('disabled', false);
		$(pass_button).prop('disabled', false);
		$(phone_button).prop('disabled', false);
	}
	
	
	var del_button = document.getElementById("delete_account");
	
	<!-- delete button, which "deletes" all current items -->
	/* del_button.onclick = function(){
		var prompt = confirm("Are you sure you want to delete your account?");
		if(prompt == true){
			document.getElementById("user_label").style.color = "red";
			document.getElementById("user_text").style.color = "red";
			document.getElementById("user_text").innerHTML = "DELETED!";
			$(user_button).prop('disabled', true);
			user_button.style.background = "gray";
			
			document.getElementById("email_label").style.color = "red";
			document.getElementById("email_text").style.color = "red";
			document.getElementById("email_text").innerHTML = "DELETED!";
			$(email_button).prop('disabled', true);
			email_button.style.background = "gray";
			
			document.getElementById("pass_label").style.color = "red";
			document.getElementById("pass_text").style.color = "red";
			document.getElementById("pass_text").innerHTML = "DELETED!";
			$(pass_button).prop('disabled', true);
			pass_button.style.background = "gray";
			
			document.getElementById("phone_label").style.color = "red";
			document.getElementById("phone_text").style.color = "red";
			document.getElementById("phone_text").innerHTML = "DELETED!";
			$(phone_button).prop('disabled', true);
			phone_button.style.background = "gray";
		}else{
			location.reload();
		}

	} */
			
</script>
</body>
</html>
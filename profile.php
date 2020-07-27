<!-- Alexander Monaco & Shreyas Mehta
CS 4640
-->

<?php session_start(); // make sessions available ?>
<?php

if (!isset($_SESSION['user']))
{
	header('Location: signin.php?error=notloggedin');
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
			<button type="button" id="delete_account" class="btn btn-block btn-danger btn-lg">Delete Account</button>
		</div>
	</div>
</div>


<!-- username change form -->
<div class="form-popup" id="user_form">
	<form action="" class="form-container">
		<h1>Change Username</h1>

		<label for="new_user"><b>New Username:</b></label>
		<input type="text" placeholder="Enter Username" id="user_entry" name="user_entry" required>

		<button type="button" id="change_user_confirm" class="btn btn-block btn-primary btn-lg">Change Username</button>
		<button type="button" id="user_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
  </form>
</div>


<!-- password change form -->
<div class="form-popup" id="pass_form">
	<form action="" class="form-container">
		<h1>Change Password</h1>

		<label for="new_user"><b>New Password:</b></label>
		<input type="text" placeholder="Enter Password" id="pass_entry" name="pass_entry" required>

		<button type="button" id="change_pass_confirm" class="btn btn-block btn-primary btn-lg">Change Password</button>
		<button type="button" id="pass_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</form>
</div>

<!-- email change form -->
<div class="form-popup" id="email_form">
	<form action="" class="form-container">
		<h1>Change Email</h1>

		<label for="new_user"><b>New Email:</b></label>
		<input type="text" placeholder="Enter Email" id="email_entry" name="email_entry" required>

		<button type="button" id="change_email_confirm" class="btn btn-block btn-primary btn-lg">Change Email</button>
		<button type="button" id="email_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</form>
</div>


<!-- phone change form -->
<div class="form-popup" id="phone_form">
	<form action="" class="form-container">
		<h1>Change Email</h1>

		<label for="new_user"><b>New Phone #:</b></label>
		<input type="text" placeholder="Enter Phone" id="phone_entry" name="phone_entry" required>

		<button type="button" id="change_phone_confirm" class="btn btn-block btn-primary btn-lg">Change Phone #</button>
		<button type="button" id="phone_form_close_btn" class="btn btn-block btn-danger btn-lg">Close</button>
	</form>
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
	del_button.onclick = function(){
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
		}

	}
			
</script>
</body>
</html>
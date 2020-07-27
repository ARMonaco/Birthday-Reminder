<!-- Used Bootstrap and Google api documentation as sources -->
<!-- Alexander Monaco and Shreyas Mehta
CS4640 -->

<?php session_start();
?>

<?php
function reject($entry)
{
   exit();    
}

function error_msg($error)
{
	$msg = "";
	switch($error){
		case "credentials":
			$msg = "Invalid username/password combination. Please try again.";
		case "usertaken":
			$msg = "Username already taken. Please try another email.";
		case "emailtaken":
			$msg = "Email already taken. Please try another email.";
		case "notloggedin":
			$msg = "You must be logged in to use this service. Please login or create an account on this page.";
	}
	echo "<script>alert('$msg');</script>";
}

if( isset($_GET["error"])){
	error_msg($_GET["error"]);
}


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	require("load_user_db.php");
   $user = trim($_POST['signinuser']);
   $pass = trim($_POST['signinpass']);

   // if (!ctype_alnum($user))   // ctype_alnum() check if the values contain only alphanumeric data
   // {
      // reject('User Name');
   // }
		
		
	$query = "SELECT * FROM user_info WHERE username='$user' AND password='$pass'";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	
	$statement->closeCursor();
	
	if (strlen($result['username']) > 0 && strlen($result['password']) > 0){
		echo "wtf mate";
		// set session attributes
         $_SESSION['user'] = $user;
         
         // $hash_pwd = md5($pwd);
		 // $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		 // $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
         
         $_SESSION['pwd'] = $pass;
		 
		 $_SESSION['email'] = $result['email'];
		 $_SESSION['phone'] = $result['phone'];
         
         // redirect the browser to another page using the header() function to specify the target URL
         header('Location: home.php');
	}else{
		echo "yo";
		header('Location: signin.php?error=credentials');
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="http://localhost.apps.googleusercontent.com">
        <title>Sign In</title>
    </head>
    <body>
        <style>
            .container{
                padding-bottom: 100px;
            }
            .container2{
                padding-bottom: 0px;
            }
            .jumbotron{
                background:url("Images/calendar1.png");
                background-position: center;
                background-size: contain;
            }
            .display-4{
                text-align: center;
            }
            .display-6{
                text-align: center;
            }
            .p{
                text-align: left;
            }
            .btn-success{
                align-content: center;
            }
            .g-signin2 > div{
              margin: auto;
            }
        </style>
        <!-- Main header lable and about us button -->
        <div class = "container2">
            <div class = "jumbotron">
                <div class= "text-center">
                    <br><br>
                    <h1 class="display-2">Welcome to Birthday Reminder</h1>
                        <hr/>
                        <!-- Help from w3schools.com on how to link to document onClick below -->
                    <button type="button" class="btn btn-info btn-lg" onclick="document.location='aboutus.html'">About Us</button>
        		</div>
            </div>
       </div>
       <br>
       <div class = "container">
           <!-- sign in username/password inputs and google sign in option -->
           <h4 class="display-4">Sign in</h4>
           <br>
		   <form id="signin_form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			   <div class="input-group input-group-lg">
				   <div class="input-group-prepend">
					   <span class="input-group-text">Username</span>
				   </div>
				   <input type="text" class="form-control" name="signinuser" id="signinuser" oninput="signInBtnDis()">
			   </div>
			   <br>
			   <div class="input-group input-group-lg">
				   <div class="input-group-prepend">
					   <span class="input-group-text">Password</span>
				   </div>
				   <input type="text" class="form-control" name="signinpass" id="signinpass" oninput="signInBtnDis()">
			   </div>
			   <input class="btn btn-block btn-outline-success" disabled=true id="signinbtn" type="submit" value="Sign in">
			</form>
           <br>
           <!--<button type="button" class="btn btn-block btn-outline-success" id="signinbtn" disabled=true onclick="validateUser()">Sign In</button>-->
           <br>
		   
		   
           <h4 class="display-6">Or</h4>
           <br>
           <div class="g-signin2" data-onsuccess="onSignIn" data-width="400" data-height="60" data-longtitle="true"></div>
           <br><hr/><br>
           <!-- New account creation -->
           <h4 class="display-4">Create New Account</h4>
           <br>
           <div class="input-group input-group-lg">
               <div class="input-group-prepend">
                   <span class="input-group-text">Username</span>
               </div>
               <input type="text" class="form-control" id="createuser" oninput="createBtnDis()">
           </div>
           <br>
           <div class="input-group input-group-lg">
               <div class="input-group-prepend">
                   <span class="input-group-text" >Email</span>
               </div>
               <input type="email" class="form-control" id="email" oninput="createBtnDis()">
           </div>
           <br>
           <div class="input-group input-group-lg">
               <div class="input-group-prepend">
                   <span class="input-group-text">Password</span>
               </div>
               <input type="password" class="form-control" id="createpass" oninput="createBtnDis()">
           </div>
           <p class="font-italic" id="passrules">Must be at least 8 chars long</p>
           <p class="text-danger" id="errorcreate"> </p>
           <div class="input-group input-group-lg">
               <div class="input-group-prepend">
                   <span class="input-group-text">Tel</span>
               </div>
               <input type="tel" class="form-control" id="createpass" placeholder="(optional)">
           </div>
           <br>
           <button type="button" class="btn btn-block btn-outline-primary" onclick="passValid()" id="createBtn" disabled=true>Create Account</button>
	

	
    </div>
    <script>
        document.getElementById("signinuser").focus(); //focus on first input on startup
        document.getElementById("createspinner").style.display = "none"; //hide loading spinner

        //Listens to input to user and pass. Enable/disable sign in button based on filled/empty fields
        function signInBtnDis(){
            user=document.getElementById("signinuser");
            pass=document.getElementById("signinpass");
            if(user.value!="" && pass.value!=""){
                document.getElementById("signinbtn").disabled=false;
            }else{
                document.getElementById("signinbtn").disabled=true;
            }
        }

        //Listens to input to user, email, and pass. Enable/disable create account button based on filled/empty fields
        function createBtnDis(){
            username=document.getElementById("createuser");
            pass=document.getElementById("createpass");
            email=document.getElementById("email");
            if(username.value!="" && pass.value!="" && email.value!=""){
                document.getElementById("createBtn").disabled=false;
            }else{
                document.getElementById("createBtn").disabled=true;
            }
        }
        //"Create account" password length validation (further rules in future)
        function passValid() { //currently only validates length (might add regex for capital/nums/special chars)
            pass=document.getElementById("createpass").value;
            if(pass.length<8){
                document.getElementById("errorcreate").innerHTML="Please enter a password that adheres to the rules shown above";
            } else{
                document.getElementById("errorcreate").innerHTML="";
                var spin= document.createElement("SPAN");
                spin.className="spinner-border spinner-border-sm";
                spin.role="status";
                document.getElementById("createBtn").innerHTML="Loading "
                document.getElementById("createBtn").appendChild(spin);
            }
        }
        //"Sign in" that validates username and password and signs in if valid
            //currently just loads for a second and then logs in
        function validateUser() { //currently no database to use to validate input
            user=document.getElementById("signinuser").value;
            pass=document.getElementById("signinpass").value;
            var spin= document.createElement("SPAN");
            spin.className="spinner-border spinner-border-sm";
            spin.role="status";
            document.getElementById("signinbtn").innerHTML="Loading "
            document.getElementById("signinbtn").appendChild(spin);
            // Insert code to check database to validate user information
            setTimeout(() => { document.location='profile.html'} ,800)
        }
    </script>
	

	
	
   </body>
 </html>

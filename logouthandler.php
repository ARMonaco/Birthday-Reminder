<?php session_start(); // make sessions available ?>
<?php

if (!isset($_SESSION['user']))
{
	header('Location: signin.php');
}

if (count($_SESSION) > 0)     // Check if there are session variables
{   
   foreach ($_SESSION as $key => $value)
   { 	
      unset($_SESSION[$key]);      
   }       
   session_destroy();
   
   header('Location: signin.php');
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
  
  <title>Logout Handler</title>    
</head>
<body>
</body>
</html>
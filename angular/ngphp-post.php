<?php

header('Access-Control-Allow-Origin: http://localhost:4200');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');


$content_length = (int) $_SERVER['CONTENT_LENGTH'];


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);



$hostname = 'localhost:3306';
$dbname = 'contact';
$username = 'BirthdayUSER';
$password = 'BirthdayShreyas!';

$dsn = "mysql:host=$hostname;dbname=$dbname";

try 
{
   $db = new PDO($dsn, $username, $password);
}
catch (PDOException $e){
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)  
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>"; 
}


$input_name = $request->name;
$input_email = $request->email;
$input_info = $request->String;

$query = "INSERT INTO `contact_forms`(`name`, `email`, `request`) VALUES ('$input_name','$input_email','$input_info')";
$statement = $db->prepare($query);
$statement->execute();
$statement->closeCursor();

$data = [];
$data[0]['length'] = $content_length;
foreach ($request as $k => $v)
{
	$data[0]['post_'.$k] = $v;
}

echo json_encode(['Request Submitted: '=>$data]);
?>
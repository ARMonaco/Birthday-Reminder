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
	<!-- loads html files for navbar and calendar -->
	<script> 
	$(function(){
		$("#header").load("navbar_header.html"); 
		$("#cal_temp").load("calendar.html"); 
		});
	</script> 
	<link rel="stylesheet" href="calendar.css" />
</head>

<body>
<!-- header at the top of the page that welcomes back user -->
<div id="header"></div>
	<div class = "container">
		<div class= "text-center">
			<br>
			<h1>Welcome back, <?php echo $_SESSION['user'];?>!</h1>
			<hr/>
			<h3>Upcoming Birthdays</h3>
		</div>
	</div>
	
<div class="container">
<br>
	<div class="row">
	<!-- calendar section -->
		<div class="col">
			<div class= "text-center">Calendar View (This Month)</div>
			<div id="cal_temp"></div>
		</div>
		
		<div class="col">
		
		<!-- list view section; will have multiple pages when back-end is implemented. -->
			<div class= "text-center">List View</div>
				<ul class="list-group">
				  <li class="list-group-item">John Doe - July 23</li>
				  <li class="list-group-item">Jane Doe - July 28</li>
				  <li class="list-group-item">Marissa Doe - July 31</li>
				  <li class="list-group-item">Wes Doe - August 3</li>
				  <li class="list-group-item">Taylor Doe - August 4</li>
				</ul>
				<div class="d-flex justify-content-center">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#">Previous</a></li>
					<li class="page-item"><a class="page-link" href="#">Next</a></li>
				</ul>
				</div>
		</div>
	</div>
	<br>
	<!-- button that takes you to address book -->
	<div class="row justify-content-md-center">
		<div class="col col-lg-4">
			<button type="button" id="address_button" class="btn btn-block btn-primary btn-lg">Create/Edit a Contact</button>
		</div>
		<script>
			var adr_button = document.getElementById("address_button");
			adr_button.onclick = () => window.location.href= "newdate.html";
		</script>
	</div>
</div>
<br>
</body>
</html>
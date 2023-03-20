<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Beam Account</title>
  </head>
  
	<body bgcolor="white">
  
  <?php
 
print "<h1>Instant Messaging</h1><hr>";

$user_a = $_GET['a'];
$user_b = $_GET['b'];

if ($_POST['username'] != "") {
	$user_a = $_POST['username'];
}

// case 1: no users at all
if (($user_a == "") AND ($user_b == "")) {
	print "No users";

}
// case 2: only one user
else if (($user_a != "") XOR ($user_b != "")) {
	$user = $user_a;
	if ($user == "") {
		$user = $user_b;
	}
	print "One user";
}

// case 3: both users exist
else {
	print "Yes users";
}

// cleanup
mysqli_close($conn);


?>

<hr>
<i>Drink Chocolate Milk<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="Return Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
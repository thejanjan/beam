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
 
$username = "";
if ($_POST['username'] != "") {
	print "Using post";
	$username = $_POST['username'];
} else {
	print "Using get";
	$username = htmlspecialchars($_GET['a']);
}
print "<h1>$username's Account</h1><hr>";

$username = mysqli_real_escape_string($conn, $username);

// Test if the username exists or not.
$read_query = "SELECT username FROM user WHERE username='".$username."';";
$read_result = mysqli_query($conn, $read_query);
$row_count = mysqli_num_rows($read_result);

if ($row_count == 0) {
	// Account does not exist, lol.
	print "The username '".$username."' does not exist.<br>";
	print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
} else {
	// Now we make the account Page
	print "heeyyyy :)";
}

mysqli_free_result($read_result);

// cleanup
mysqli_close($conn);


?>

<hr>
<i>Providing Sensitive User Information Since 1991<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="Go Back" onclick="history.back()">
</form>

</body>
</html>
	  
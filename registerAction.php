<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Registration Action</title>
  </head>
  
	<body bgcolor="white">
  
  <?php
  
$username = $_POST['username'];

if (strlen($username) > 20) {
	print "<h1>USERNAME TOO LONG.</h1><hr>";
	print "ERROR: Username is too long. You scoundrel. Look at this foolish name: ".$username;
} else if (strlen($username) <= 0) {
	print "<h1>USERNAME IS INVALID</h1><hr>";
	print "ERROR: Please specify a valid username!!";
} else {
	$username = mysqli_real_escape_string($conn, $username);

	// Test if the username exists or not.
	$read_query = "SELECT username FROM user WHERE username='".$username."';";
	$read_result = mysqli_query($conn, $read_query);
	$row_count = mysqli_num_rows($read_result);

	if ($row_count != 0) {
		print "<h1>ACCOUNT ALREADY REGISTERED</h1><hr>";
		print "The username '".$username."' is already taken.<br>";
		print "You can use it at any time, without the need to register.";
	} else {
		// It exists, so now write the username.
		$write_query = "INSERT INTO user VALUES ('".$username."', null, CURRENT_TIMESTAMP);";
		$write_result = mysqli_query($conn, $write_query)
		or die(mysqli_error($conn));

		print "<h1>A SUCCESSFUL REGISTRATION</h1><hr>";
		print "The username '".$username."' has been registered. Excellent!<br>";
		print "Please head back to use your brand new account.";

		mysqli_free_result($write_result);
	}

	mysqli_free_result($read_result);
}

// cleanup
mysqli_close($conn);

?>

<br><br>
<form>
 <input type="button" value="Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
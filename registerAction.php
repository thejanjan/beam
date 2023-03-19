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
  
  <h1>REGISTERING ACCOUNT...</h1>
  <hr>

  <?php
  
$username = $_POST['username'];

if (strlen($username) > 20) {
	print "ERROR: Username is too long. You scoundrel. Look at this foolish name: ".$username;
} else if (strlen($username) <= 0) {
	print "ERROR: Please specify a valid username!!";
} else {
	$username = mysqli_real_escape_string($conn, $username);

	// Test if the username exists or not.
	$read_query = "SELECT * FROM user u WHERE u.username=".$username.";";
	$read_result = mysqli_query($conn, $read_query)
	or die(mysqli_error($conn));

	if (mysqli_num_rows($read_result) != 0) {
		print "The username '".$username."' is already taken.<br>";
		print "You can use it at any time.";
	} else {
		// It exists, so now write the username.
		$write_query = "INSERT INTO user VALUES ('".$username."', null);";
		$write_result = mysqli_query($conn, $write_query)
		or die(mysqli_error($conn));

		print "The username '".$username."' has been registered. Excellent!<br>";
		print "Please head back to use your brand new account.";

		mysqli_free_result($write_result);
	}

	mysqli_free_result($read_result);
}

// cleanup
mysqli_close($conn);

?>

</body>
</html>
	  
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
  
  
  <hr>

  <?php
  
$username = $_POST['username'];

if (strlen($username) > 20) {
	print "ERROR: Username is too long. You scoundrel. Look at this foolish name: ".$username;
} else if (strlen($username) <= 0) {
	print "ERROR: Please specify a valid username!!";
} else {
	$username = mysqli_real_escape_string($conn, $username);
	$query = "INSERT INTO user VALUES ('".$username."', null);";

	$result = mysqli_query($conn, $query)
	or die(mysqli_error($conn));

	print "The username '".$username."' has been registered. Excellent!;";
	print "Please head back to use your brand new account.";

	mysqli_free_result($result);
}

// cleanup
mysqli_close($conn);

?>

</body>
</html>
	  
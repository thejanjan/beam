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
 
print "<h1>Instan-Messaging</h1><hr>";

$user_a = $_GET['a'];
$user_b = $_GET['b'];

if ($_POST['username'] != "") {
	$user_a = $_POST['username'];
}

// case 1: no users at all
if (($user_a == "") AND ($user_b == "")) {
	print 'People on the Internet <b>LOVE to</b> Insta-Message their Friends!<br />';
    print 'Please type in a username below for who you would like to Insta-Message under!';
    print '<form action="messaging.php" method="POST">';
	print '<input type="text" name="username">';
    print '<input type="submit" value="Start Messaging">';
    print '</form>';
}
// case 2: only one user
else if (($user_a != "") XOR ($user_b != "")) {
	$user = $user_a;
	if ($user == "") {
		$user = $user_b;
	}

	// Test if the username exists or not.
	$read_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$user."';";
	$read_result = mysqli_query($conn, $read_query);
	$row_count = mysqli_num_rows($read_result);

	if ($row_count == 0) {
		// Account does not exist, lol.
		print "The username '".$user."' does not exist.<br>";
		print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
	} else {
		print "One user";
	}
}

// case 3: both users exist
else {
	// Test if the username exists or not.
	$read_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$user."';";
	$read_result = mysqli_query($conn, $read_query);
	$row_count = mysqli_num_rows($read_result);

	if ($row_count == 0) {
		// Account does not exist, lol.
		print "The username '".$user."' does not exist.<br>";
		print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
	} else {
		print "Two user";
	}
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
	  
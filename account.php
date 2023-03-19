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
	$username = $_POST['username'];
} else {
	$username = htmlspecialchars($_GET['a']);
}
print "<h1>$username's Account</h1><hr>";

$clean_username = mysqli_real_escape_string($conn, $username);

// Perform an avatar URL post query if we have one set in POST.
if ($_POST['avatar'] != "") {
	$avatar_query = "UPDATE user SET avatar_url = '".$_POST['avatar']."' WHERE username='".$clean_username."';";
	$avatar_result = mysqli_query($conn, $avatar_query);
}

// Test if the username exists or not.
$read_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$clean_username."';";
$read_result = mysqli_query($conn, $read_query);
$row_count = mysqli_num_rows($read_result);

if ($row_count == 0) {
	// Account does not exist, lol.
	print "The username '".$username."' does not exist.<br>";
	print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
} else {
	// Now we make the account Page
	$row = mysqli_fetch_array($read_result, MYSQLI_BOTH);
	print "Good day, $username.<br>";
	print "Remember that beautiful time of $row[timestamp]? The exact time you registered for Beam?";
	print "<br>(I remember.)";

	print "<br><h3>Set Profile Picture</h3>";
	print "Your current profile picture is shown below.";
	print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$row[avatar_url]' width='100' height='100'></p></td>";
	print "<i>Link: $row[avatar_url]</i>";
	print "<br><br>You can put a new link to an image to set it as your avatar below.<br>";


	print '<form action="account.php?a='.$username.'" method="POST">';
	print '<input type="text" name="avatar">';
	print '<input type="submit" value="Set Avatar">';
	print '</form>';
	
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
	  
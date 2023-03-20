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

	// Profile Pictures
	print "<br><h3>Set Profile Picture</h3>";
	print "Your current profile picture is shown below.";
	print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$row[avatar_url]'></p></td>";
	print "<i>Link: $row[avatar_url]</i>";
	print "<br><br>You can put a new link to an image to set it as your avatar below.<br>";

	print '<form action="account.php?a='.$username.'" method="POST">';
	print '<input type="text" name="avatar">';
	print '<input type="submit" value="Set Avatar">';
	print '</form>';
	
	// Incoming Friend Requests
	$friend_request_query = "SELECT user_a, user_b, status FROM friendstatus WHERE user_b='".$username."' AND status='request';";
	$friend_request_result = mysqli_query($conn, $friend_request_query)
	or die(mysqli_error($conn));

	$row_count = mysqli_num_rows($friend_request_result);

	print "<br><h3>Friend Requests</h3>";
	print "You currently have <b>$row_count incoming friend requests.</b><br>";
	
	if ($row_count != 0) {
		print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
		print "<th>Avatar</th><th>User</th><th>Actions</th>";

		$index = 0;
		while ($row = mysqli_fetch_array($friend_request_result, MYSQLI_BOTH)) {
			$index = $index + 1;
			print "<tr>";
			print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$row[avatar_url]'></p></td>";
			print "<td>Request #$index:<br>$row[username]</td>";
			print "<td>";
			print "<a title='Account' href='account.php?a=".$username."&b=$row[username]&m=1'>Approve</a>";
			print "<a title='Account' href='account.php?a=".$username."&b=$row[username]&m=0'>Decline</a>";
			print "<a title='Account' href='account.php?a=".$username."&b=$row[username]&m=2'>Block</a>";
			print "<br><a title='Account' href='account.php?a=$row[username]'>Visit Account</a>";
			print "</td>";
			print "</tr>";
		}

		print "</tbody></table>";
	}

	mysqli_free_result($friend_request_result);

	// Outgoing Friend Requests
	$friend_request_query = "SELECT user_a, user_b, status FROM friendstatus WHERE user_a='".$username."' AND status='request';";
	$friend_request_result = mysqli_query($conn, $friend_request_query)
	or die(mysqli_error($conn));

	$row_count = mysqli_num_rows($friend_request_result);

	print "<br>You currently have <b>$row_count outgoing friend requests.</b><br>";
	
	if ($row_count != 0) {
		print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
		print "<th>Avatar</th><th>User</th><th>Actions</th>";

		$index = 0;
		while ($row = mysqli_fetch_array($friend_request_result, MYSQLI_BOTH)) {
			$index = $index + 1;
			print "<tr>";
			print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$row[avatar_url]'></p></td>";
			print "<td>Request #$index:<br>$row[username]</td>";
			print "<td>";
			print "<a title='Account' href='account.php?a=".$username."&b=$row[username]&m=3'>Remove</a>";
			print "<br><a title='Account' href='account.php?a=$row[username]'>Visit Account</a>";
			print "</td>";
			print "</tr>";
		}

		print "</tbody></table>";
	}

	mysqli_free_result($friend_request_result);

	
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
	  
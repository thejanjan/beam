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
	mysqli_free_result($avatar_result);

	print "<h2>Account Update</h2>Your profile picture has been set successfully!<hr>";
}

// Perform a friend request send query if we have one set in POST.
if ($_POST['add_friend'] != "") {
	// No sending friend requests to ourselves.
	if ($_POST['add_friend'] == $username) {
		print "<h2>Account Update</h2>You cannot befriend yourself!<br><b>(DO NOT VIOLATE BEAM POLICY.)</b><hr>";
	} else {
		// First, ensure that user even exists.
		$user_exists_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$_POST['add_friend']."';";
		$user_exists_result = mysqli_query($conn, $user_exists_query);
		if (mysqli_num_rows($user_exists_result) == 0) {
			// No user exists.
			print "<h2>Account Update</h2>That user does not exist!<hr>";
		} else {
			// Now, ensure there is not one sent already.
			$af_check_relation_query = "SELECT user_a, user_b, status FROM friendstatus WHERE (user_a='".$clean_username."' AND user_b='".$_POST['add_friend']."') OR (user_a='".$_POST['add_friend']."' AND user_b='".$clean_username."');";
			$af_check_relation_result = mysqli_query($conn, $af_check_relation_query);
			if (mysqli_num_rows($af_check_relation_result) != 0) {
				// Relation exists, check relation and give relevant error message
				print "<h2>Account Update</h2>You cannot send a friend request to this user!<hr>";
				/*
				$row = mysqli_fetch_array($af_check_relation_result, MYSQLI_BOTH);
				if ($row[status] == "request") {
					print "<h2>Account Update</h2>There is already an active friend request!<hr>";
				} else if ($row[status] == "yes") {
					print "<h2>Account Update</h2>You guys are already friends!<hr>";
				} else if ($row[status] == "block") {
					print "<h2>Account Update</h2>You guys have blocked each other!<hr>";
				}
				*/
			} else {
				// There is no relation between users.
				// Send a friend request their way.
				$write_query = "INSERT INTO friendstatus VALUES ('".$username."', '".$_POST['add_friend']."', 'request');";
				$write_result = mysqli_query($conn, $write_query);

				print "<h2>Account Update</h2>Friend request sent successfully!<hr>";
			}
			mysqli_free_result($af_check_relation_result);
		}
		mysqli_free_result($user_exists_result);
	}
}

// If there is a B user in our GET, then we have to perform some action.
if ($_GET['b'] != "") {
	$action = $_GET['m'];

	switch ($action) {
		case 0:
			// Decline Incoming Friend Request 
			$rof_query = "DELETE FROM friendstatus WHERE user_b='$clean_username' AND user_a='$_GET[b]';";
			mysqli_query($conn, $rof_query);
			print "<h2>Account Update</h2>Removed incoming friend request.<hr>";
			break;
		case 1:
			// Approve Incoming Friend Request
			$rof_query = "UPDATE friendstatus SET status='yes' WHERE user_b='$clean_username' AND user_a='$_GET[b]';";
			mysqli_query($conn, $rof_query);
			print "<h2>Account Update</h2>Added a brand new friend! Great job!<hr>";
			break;
		case 2:
			// Block User 
			break;
		case 3:
			// Remove Outgoing Friend Request
			$rof_query = "DELETE FROM friendstatus WHERE user_a='$clean_username' AND user_b='$_GET[b]';";
			mysqli_query($conn, $rof_query);
			print "<h2>Account Update</h2>Removed outgoing friend request.<hr>";
			break;
		case 4:
			// Remove Relation
			$rof_query = "DELETE FROM friendstatus WHERE (user_a='$clean_username' AND user_b='$_GET[b]') OR (user_b='$clean_username' AND user_a='$_GET[b]');";
			mysqli_query($conn, $rof_query);
			print "<h2>Account Update</h2>Removed friend.<hr>";
			break;
	}
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

	// Friends
	$friend_query = "SELECT user_a, user_b, status FROM friendstatus WHERE (user_a='".$username."' OR user_b='".$username."') AND status='yes';";
	$friend_result = mysqli_query($conn, $friend_query)
	or die(mysqli_error($conn));

	$row_count = mysqli_num_rows($friend_result);

	print "<h3>Friends</h3>";
	print "<br>You currently have <b>$row_count friends.</b><br>";
	
	if ($row_count != 0) {
		print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
		print "<th>Avatar</th><th>User</th><th>Actions</th>";

		$index = 0;
		while ($row = mysqli_fetch_array($friend_result, MYSQLI_BOTH)) {
			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$row[user_b]';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				$index = $index + 1;
				print "<tr>";
				print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$user_row[avatar_url]'></p></td>";
				print "<td>$row[user_b]</td>";
				print "<td>";
				print "<a title='Account' href='account.php?a=".$username."&b=$row[user_b]&m=4'>Remove</a>";
				print "<br><a title='Account' href='account.php?a=$row[user_b]'>Visit Account</a>";
				print "</td>";
				print "</tr>";
			}
			mysqli_free_result($user_result);
		}

		print "</tbody></table>";
	}

	mysqli_free_result($friend_result);
	
	// Incoming Friend Requests
	$friend_request_query = "SELECT user_a, user_b, status FROM friendstatus WHERE user_b='".$username."' AND status='request';";
	$friend_request_result = mysqli_query($conn, $friend_request_query)
	or die(mysqli_error($conn));

	$row_count = mysqli_num_rows($friend_request_result);

	print "<h3>Friend Requests</h3>";
	print "You currently have <b>$row_count incoming friend requests.</b><br>";
	
	if ($row_count != 0) {
		print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
		print "<th>Avatar</th><th>User</th><th>Actions</th>";

		$index = 0;
		while ($row = mysqli_fetch_array($friend_request_result, MYSQLI_BOTH)) {
			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$row[user_a]';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				$index = $index + 1;
				print "<tr>";
				print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$user_row[avatar_url]'></p></td>";
				print "<td>$row[user_a]</td>";
				print "<td>";
				print "<a title='Account' href='account.php?a=".$username."&b=$row[user_a]&m=1'>Approve</a>";
				print "<br><a title='Account' href='account.php?a=".$username."&b=$row[user_a]&m=0'>Decline</a>";
				// print "<br><a title='Account' href='account.php?a=".$username."&b=$row[user_a]&m=2'>Block</a>";
				print "<br><a title='Account' href='account.php?a=$row[user_a]'>Visit Account</a>";
				print "</td>";
				print "</tr>";
			}
			mysqli_free_result($user_result);
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
			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$row[user_b]';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				$index = $index + 1;
				print "<tr>";
				print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$user_row[avatar_url]'></p></td>";
				print "<td>$row[user_b]</td>";
				print "<td>";
				print "<a title='Account' href='account.php?a=".$username."&b=$row[user_b]&m=3'>Remove</a>";
				print "<br><a title='Account' href='account.php?a=$row[user_b]'>Visit Account</a>";
				print "</td>";
				print "</tr>";
			}
			mysqli_free_result($user_result);
		}

		print "</tbody></table>";
	}

	mysqli_free_result($friend_request_result);

	// Send Friend Request Prompt
	print "<br>You can type a username here to send a friend request to them.<br>";
	print '<form action="account.php?a='.$username.'" method="POST">';
	print '<input type="text" name="add_friend">';
	print '<input type="submit" value="Send Friend Request">';
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
 <input type="button" value="Go Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
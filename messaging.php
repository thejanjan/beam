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
 
print "<h1>Insta-Messaging</h1><hr>";

$user_a = htmlspecialchars($_GET['a']);
$user_b = htmlspecialchars($_GET['b']);

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
	$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$user."';";
	$user_result = mysqli_query($conn, $user_query);
	$row_count = mysqli_num_rows($user_result);

	if ($row_count == 0) {
		// Account does not exist, lol.
		print "The username '".$user."' does not exist.<br>";
		print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
	} else {
		// Friend selection to message
		$friend_query = "SELECT user_a, user_b, status FROM friendstatus WHERE (user_a='".$user."' OR user_b='".$user."') AND status='yes';";
		$friend_result = mysqli_query($conn, $friend_query)
		or die(mysqli_error($conn));

		$row_count = mysqli_num_rows($friend_result);
	
		if ($row_count != 0) {
			print "Please select a friend to Insta-Message!";
			print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
			print "<th>Avatar</th><th>User</th><th>Actions</th>";

			$index = 0;
			while ($row = mysqli_fetch_array($friend_result, MYSQLI_BOTH)) {
				$other_user = $row[0];
				if ($row[0] == $user) {
					$other_user = $row[1];
				}

				$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$other_user';";
				$user_result = mysqli_query($conn, $user_query);
				if (mysqli_num_rows($user_result) != 0) {
					$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
					$index = $index + 1;
					print "<tr>";
					print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$user_row[avatar_url]'></p></td>";
					print "<td>$other_user</td>";
					print "<td>";
					print "<a title='Message' href='messaging.php?a=".$user."&b=$other_user'>Start Messaging</a>";
					print "<br><a title='Account' href='account.php?a=$other_user'>Visit Account</a>";
					print "</td>";
					print "</tr>";
				}
				mysqli_free_result($user_result);
			}

			print "</tbody></table>";
		} else {
			print "You do not have any friends that you can Insta-Message!";
		}

		mysqli_free_result($friend_result);
	}

	mysqli_free_result($user_result);
}

// case 3: both users exist
else {
	// Test if the username exists or not.
	$user_a_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$user_a."';";
	$user_a_result = mysqli_query($conn, $user_a_query);
	$row_count = mysqli_num_rows($user_a_result);

	if ($row_count == 0) {
		// Account does not exist, lol.
		print "The username '".$user_a."' does not exist.<br>";
		print "Please <a title='Register' href='register.html'>click here</a> to register an account.";
	} else {
		$user_b_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='".$user_b."';";
		$user_b_result = mysqli_query($conn, $user_b_query);
		$row_count = mysqli_num_rows($user_b_result);

		if ($row_count == 0) {
			// Account does not exist, lol.
			print "The username '".$user_b."' does not exist.<br>";
		} else {
			if ($_POST['message'] != "") {
				// Send a message to user B here.
				$msg = $_POST['message'];
				$write_query = "INSERT INTO privatemessage (sender, receiver, message, timestamp) VALUES ('$user_a', '$user_b', '$msg', CURRENT_TIMESTAMP);";
				mysqli_query($conn, $write_query);
			}

			print "You are now Insta-Messaging $user_b!<br>";
			print "<br>Enter a message below to send it to them.";
			print '<form action="messaging.php?a='.$user_a.'&b='.$user_b.'" method="POST">';
			print '<input type="text" name="message">';
			print '<input type="submit" value="Send">';
			print '</form>';

			$msg_query = "SELECT message_id, sender, receiver, message, timestamp FROM privatemessage WHERE (sender == '$user_a' AND receiver == '$user_b') OR (sender == '$user_b' AND receiver == '$user_a') ORDER BY timestamp DESC;";
			$msg_result = mysqli_query($conn, $msg_query)
			or die(mysqli_error($conn));

			$row_count = mysqli_num_rows($msg_result);
	
			if ($row_count != 0) {
				print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
				print "<th>Avatar</th><th>User</th><th>Message</th><th>Timestamp</th>";

				$index = 0;
				while ($row = mysqli_fetch_array($friend_result, MYSQLI_BOTH)) {
					$avatar = $user_a_query[avatar_url];
					if ($row[sender] == receiver) {
						$avatar = $user_b_query[avatar_url];
					}
					$index = $index + 1;
					print "<tr>";
					print "<td><p><img alt='Cool Avatar' width='100' height='100' src='$avatar'></p></td>";
					print "<td>$other_user</td>";
					print "<td>$row[message]</td>";
					print "<td>$row[timestamp]</td>";
					print "</tr>";
				}

				print "</tbody></table>";
			}

			mysqli_free_result($msg_result);
		}

		mysqli_free_result($user_b_result);
	}

	mysqli_free_result($user_a_result);
}

// cleanup
mysqli_close($conn);


?>

<hr>
<i>Drink water please<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="Return Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
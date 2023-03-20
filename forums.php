<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Forums</title>

  </head>
  
	<body bgcolor="white">
  
  <?php

  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check what game we are looking at.
$game_id = $_GET['g'];

if ($game_id == "") {
	// No game, show forums for all games.
	print "<h1>Beam Forums</h1><hr>";
	print "Check out the Forums for your favorite game.";

	$game_query = "SELECT game_id, name, description, image FROM game;";
	$game_result = mysqli_query($conn, $game_query)
	or die(mysqli_error($conn));
	$row_count = mysqli_num_rows($game_result);

	while ($row = mysqli_fetch_array($game_result, MYSQLI_BOTH)) {
		$gid = $row[0];
		print "<hr>";
		print "<img src=$row[image] alt='Gaming' width='100' height='100' style='float:left'>";
		print "<h2>$row[name]</h2>$row[description]<br>";
		print "<a title='Game' href='game.php?g=$gid'>Open Game Page</a>";
		print " | ";
		print "<a title='Forums' href='forums.php?g=$gid'>See Forum Discussion</a>";
		print "<br>";
	}
 
	// cleanup
	mysqli_free_result($game_result);

} else {
	// We are looking at a game.
	/*
	$game_query = "SELECT game_id, name, description, image FROM game WHERE game_id='$game_id';";
	$game_result = mysqli_query($conn, $game_query);
	$row_count = mysqli_num_rows($game_result);
	if ($row_count == 0) {
		die();
	}
	$row = mysqli_fetch_array($game_result, MYSQLI_BOTH)
	mysqli_free_result($game_result);

	$game_name = $row[name];
	$game_desc = $row[description];
	$game_img = $row[image];
	
	// Any specific topic?
	$topic_id = $_GET['t'];

	if ($topic_id == "") {
		// No specific topic. List all visible topics.
		// Start with the header.
		print "<h1>$game_name - Topics</h1><hr>";
		print "Check out the Topics for your favorite game.";

		// Leave a Review entry
		print "<h3>Create a Topic</h3>";
		print "Create a topic for this game below!<br>";
		print "<form action='forums.php?g=$game_id' method='POST'>";
		print "<label for='username'>Username: </label>";
		print "<input type='text' id='username' name='username'><br>";
		print "<label for='topic'>Topic Name: </label>";
		print "<input type='text' id='topic' name='topic'><br>";
		print "<input type='submit' value='Create'>";
		print "</form>";

		// And now the topic list.
		
		$topic_query = "SELECT topic_id, game_id, username, topic_name, timestamp FROM topic WHERE game_id=$game_id;";
		$topic_result = mysqli_query($conn, $topic_query)
		or die(mysqli_error($conn));
		$row_count = mysqli_num_rows($topic_result);

		while ($row = mysqli_fetch_array($topic_result, MYSQLI_BOTH)) {
			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$row[username]';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				print "<hr>";
				print "<img src=$user_row[avatar_url] alt='Gaming' width='100' height='100' style='float:left'>";
				print "<h2>$row[topic_name]</h2>by $row[username] - $row[timestamp]<br>";
				print "<a title='Topic' href='forums.php?g=$gid&t=$row[topic_id]'>Open Topic</a>";
				print "<br>";
			}
		}
 
		// cleanup
		mysqli_free_result($topic_result);
		*/
	} else {
		// List all posts from this topic.
	}
}

// cleanup
mysqli_close($conn);

?>

<hr>
<i>We Love Ideas.<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="I Want To Go Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
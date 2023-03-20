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
		print "<h2><a title='Forums' href='forums.php?g=$gid'>$row[name]</a></h2>$row[description]";
		print "<br><br><br>";
	}
 
	// cleanup
	mysqli_free_result($game_result);

} else {
	// We are looking at a game.
	
	$game_query = "SELECT game_id, name, description, image FROM game WHERE game_id='$game_id';";
	$game_result = mysqli_query($conn, $game_query);
	$row_count = mysqli_num_rows($game_result);
	if ($row_count == 0) {
		die();
	}
	
	$row = mysqli_fetch_array($game_result, MYSQLI_BOTH);
	
	$game_name = $row[1];
	$game_desc = $row[2];
	$game_img = $row[3];

	mysqli_free_result($game_result);
	
	// Any specific topic?
	$topic_id = $_GET['t'];

	if ($topic_id == "") {
		// No specific topic. List all visible topics.
		// Start with the header.
		print "<h1>$game_name - Topics</h1><hr>";
		print "Check out the Topics for your favorite game.";

		// Check POST request for adding a topic
		if ($_POST['username'] != "") {
			// Get post constants.
			$username = $_POST['username'];
			$topic = $_POST['topic'];

			// First, ensure that user even exists.
			$user_exists_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$username';";
			$user_exists_result = mysqli_query($conn, $user_exists_query);
			if (mysqli_num_rows($user_exists_result) != 0) {
				// Add the topic.
				$write_query = "INSERT INTO topic (game_id, username, topic_name, timestamp) VALUES ('$game_id', '$username', '$topic', CURRENT_TIMESTAMP);";
				mysqli_query($conn, $write_query);
			}
			mysqli_free_result($user_exists_result);
		}

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
		
		$topic_query = "SELECT topic_id, game_id, username, topic_name, timestamp FROM topic WHERE game_id=$game_id ORDER BY timestamp DESC;";
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
				print "<h2><a title='Topic' href='forums.php?g=$game_id&t=$row[topic_id]'>$row[topic_name]</a></h2>";
				print "by $row[username] - $row[timestamp]";
				print "<br><br><br>";
			}
		}
 
		// cleanup
		mysqli_free_result($topic_result);
		
	} else {
		// List all posts from this topic.
		$topic_query = "SELECT topic_id, username, topic_name, timestamp FROM topic WHERE topic_id='$topic_id';";
		$topic_result = mysqli_query($conn, $topic_query);
		$row_count = mysqli_num_rows($topic_result);
		if ($row_count == 0) {
			die();
		}
	
		$row = mysqli_fetch_array($topic_result, MYSQLI_BOTH);
	
		$op_name = $row[1];
		$topic_name = $row[2];
		$topic_timestamp = $row[3];

		mysqli_free_result($topic_result);

		// Start with the header.
		print "<h1>$topic_name - by $op_name</h1><hr>";

		// Check POST request for adding a post
		if ($_POST['username'] != "") {
			// Get post constants.
			$username = $_POST['username'];
			$post = $_POST['post'];

			// First, ensure that user even exists.
			$user_exists_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$username';";
			$user_exists_result = mysqli_query($conn, $user_exists_query);
			if (mysqli_num_rows($user_exists_result) != 0) {
				// Add the post.
				$write_query = "INSERT INTO post (topic_id, username, message, timestamp) VALUES ('$topic_id', '$username', '$post', CURRENT_TIMESTAMP);";
				mysqli_query($conn, $write_query);
			}
			mysqli_free_result($user_exists_result);
		}

		// Leave a Review entry
		print "<h3>Add a Post</h3>";
		print "Add a Post into this Topic.<br>";
		print "<form action='forums.php?g=$game_id&t=$topic_id' method='POST'>";
		print "<label for='username'>Username: </label>";
		print "<input type='text' id='username' name='username'><br>";
		print "<label for='topic'>Topic Name: </label>";
		print "<input type='text' id='topic' name='topic'><br>";
		print "<input type='submit' value='Post'>";
		print "</form>";

		// And now the topic list.
		
		$post_query = "SELECT topic_id, username, message, timestamp FROM post WHERE topic_id=$topic_id ORDER BY timestamp DESC;";
		$post_result = mysqli_query($conn, $post_query)
		or die(mysqli_error($conn));
		$row_count = mysqli_num_rows($post_result);

		while ($row = mysqli_fetch_array($post_result, MYSQLI_BOTH)) {
			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$row[username]';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				print "<hr>";
				print "<img src=$user_row[avatar_url] alt='Gaming' width='100' height='100' style='float:left'>";
				print "<h2>$row[username] - $row[timestamp]</h2>";
				print "$row[message]";
				print "<br><br><br>";
			}
		}
 
		// cleanup
		mysqli_free_result($post_result);
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
	  
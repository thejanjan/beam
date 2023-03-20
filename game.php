<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Game Browser</title>

  </head>
  
	<body bgcolor="white">
  
  <?php


$game_id = $_GET['g'];
$game_query = "SELECT game_id, name, description, releasedate, cost, publisher, developer, website, image FROM game WHERE game_id='$game_id';";
$game_result = mysqli_query($conn, $game_query);

$row_count = mysqli_num_rows($game_result);

if ($row_count == 0) {
	die();
} else {
	$row = mysqli_fetch_array($game_result, MYSQLI_BOTH);

	// Check POST request for adding a review
	if ($_POST['username'] != "") {
		// Get post constants.
		$username = $_POST['username'];
		$review = $_POST['review'];
		$rating = $_POST['rating'];

		// First, ensure that user even exists.
		$user_exists_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$username';";
		$user_exists_result = mysqli_query($conn, $user_exists_query);
		if (mysqli_num_rows($user_exists_result) != 0) {
			// Add the review.
			$write_query = "INSERT INTO review (game_id, username, rating, description, timestamp) VALUES ('$game_id', '$username', '$rating', '$review', CURRENT_TIMESTAMP);";
			mysqli_query($conn, $write_query);
		}
		mysqli_free_result($user_exists_result);
	}

	// Print header fields.
	print "<h1>$row[name]</h1><h3>$"."$row[cost]</h3><hr>";
	print "<img src=$row[image] alt='Gaming' width='450' height='450' style='float:right'>";
	print "$row[description]";
	print "<br>";
	print "<br>Release Date: $row[releasedate]";
	print "<br>Publisher: $row[publisher]";
	print "<br>Developer: $row[developer]";
	print "<br>Website: <a>$row[website]</a>";

	// Leave a Review entry
	print "<hr><h3>Leave a Review</h3>";
	print "Leave a review on this game below!<br>";
	print "<form action='game.php?g=$game_id' method='POST'>";
	print "<label for='username'>Username: </label>";
	print "<input type='text' id='username' name='username'><br>";
	print "<label for='review'>Review: </label>";
	print "<input type='text' id='review' name='review'><br>";
	print "<label for='rating'>Rating: </label>";
	print "<input type='range' id='rating' name='rating' min='0' max='100'><br>";
	print "<input type='submit' value='Submit'>";
	print "</form>";

	// List all reviews
	$review_query = "SELECT review_id, game_id, username, rating, description, timestamp FROM review WHERE game_id=$game_id ORDER BY timestamp DESC;";
	$review_result = mysqli_query($conn, $review_query)
	or die(mysqli_error($conn));

	$row_count = mysqli_num_rows($review_result);
	
	if ($row_count != 0) {
		print "<hr><h2>All Reviews ($row_count)</h2>";
		$index = 0;
		while ($row = mysqli_fetch_array($review_result, MYSQLI_BOTH)) {
			$review_id = $row[0];
			$username = $row[2];
			$rating = $row[3];
			$description = $row[4];

			$user_query = "SELECT username, avatar_url, timestamp FROM user WHERE username='$username';";
			$user_result = mysqli_query($conn, $user_query);
			if (mysqli_num_rows($user_result) != 0) {
				$user_row = mysqli_fetch_array($user_result, MYSQLI_BOTH);
				$index = $index + 1;
				print "<hr>";
				print "<img src=$user_row[avatar_url] alt='Gaming' width='100' height='100' style='float:right'>";
				print "<h2>Review from $username: $rating/100</h2>";
				print "$description";
				print "<br><br>";
				print "<i>What emotion did this review spark?</i><br>";
				print "<form action='game.php?g=$game_id&r=$review_id' method='POST'>";
				print "<label for='rusername'>Username: </label>";
				print "<input type='text' id='rusername' name='rusername'><br>";
				print "<input type='radio' id='funny' name='rating' value='funny'>";
				print "<label for='funny'>😂 Funny</label><br>";
				print "<input type='radio' id='true' name='rating' value='true'>";
				print "<label for='true'>✅ True</label><br>";
				print "<input type='radio' id='tragic' name='rating' value='tragic'>";
				print "<label for='tragic'>💧 Tragic</label><br>";
				print "<input type='submit' value='Submit'>";
				print "</form>";
			}
			mysqli_free_result($user_result);
		}
	}

	mysqli_free_result($review_result);
}

// cleanup
mysqli_free_result($game_result);
mysqli_close($conn);

?>

<hr>
<i>Enjoy Your Stay.<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="Let's Go Home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
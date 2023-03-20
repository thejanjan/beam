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
	// We are looking at a game. Any specific topic?
	$topic_id = $_GET['t'];

	if ($topic_id == "") {
		// No specific topic. List all visible topics.
	} else {
		// List all posts from this topic.
	}
	$game_query = "SELECT game_id, name, description, releasedate, cost, publisher, developer, website, image FROM game WHERE game_id='$game_id';";
	$game_result = mysqli_query($conn, $game_query);
	$row_count = mysqli_num_rows($game_result);
	mysqli_free_result($game_result);
	

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
	  
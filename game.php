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

	print "<h1>$row[name]</h1><h3>$"."$row[cost]</h3><hr>";
	print "<img src=$row[image] alt='Gaming' width='450' height='450' style='float:right'>";
	print "$row[description]";
	print "<br>";
	print "<br>Release Date: $row[releasedate]";
	print "<br>Publisher: $row[publisher]";
	print "<br>Developer: $row[developer]";
	print "<br>Website: <a>$row[website]</a>";

	print "<hr><h3>Reviews</h3>";
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
	  
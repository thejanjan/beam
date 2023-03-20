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

	print "<h1>$row[name]</h1><hr>";
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
	  
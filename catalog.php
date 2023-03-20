<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Game Catalog</title>

  </head>
  
	<body bgcolor="white">

	<h1>Game Catalog</h1><hr>

	You won't BELIEVE how many Games exist on the Beam Hypernet!
  
  <?php

$game_query = "SELECT name, description, cost, developer, image FROM game;";
$game_result = mysqli_query($conn, $game_query)
or die(mysqli_error($conn));

$row_count = mysqli_num_rows($game_result);

print "<br>Actually, I'll tell you: There are <b>$row_count games!</b>";

while ($row = mysqli_fetch_array($game_result, MYSQLI_BOTH)) {
	print "<hr>";
	print "<img src=$row[image] alt='Gaming' width='150' height='150' style='float:left'>";
	print "<h3>$row[name]</h3>$row[description]";
	print "<h2>$"."$row[cost]</h2>";
	print "<br>Open Game Page | See Forum Discussion<br>";
}
 
// cleanup
mysqli_close($conn);


?>

<hr>
<i>There Are Two Kinds Of Games.<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="home" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
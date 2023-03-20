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

$game_query = "SELECT game_id, name, description, cost, developer, image FROM game;";
$game_result = mysqli_query($conn, $game_query)
or die(mysqli_error($conn));

$row_count = mysqli_num_rows($game_result);

print "<br>Actually, I'll tell you: There are <b>$row_count games!</b>";

while ($row = mysqli_fetch_array($game_result, MYSQLI_BOTH)) {
	$gid = $row[0];
	print "<hr>";
	print "<img src=$row[image] alt='Gaming' width='150' height='150' style='float:left'>";
	print "<h2>$row[name]</h2>$row[description]";
	print "<h3>$"."$row[cost]</h3><br>";
	print "<a title='Game' href='game.php?g=$gid'>Open Game Page</a>";
	print " | ";
	print "<a title='Forums' href='forums.php?g=$gid'>See Forum Discussion</a>";
	print "<br>";
}
 
// cleanup
mysqli_free_result($game_result);
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
	  
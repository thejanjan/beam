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
	  
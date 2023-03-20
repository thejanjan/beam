<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Table Contents</title>

  </head>
  
	<body bgcolor="white">

	<h1>Table Contents</h1><hr>

	A data dump of the contents within all tables.
  
  <?php

// User Table
print "<hr><h2>User Table</h2>";
$query = "SELECT username, avatar_url, timestamp FROM user;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>username</th><th>avatar_url</th><th>timestamp</th>";
$index = $row_count + 1;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index - 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$username</td>";
	print "<td>$avatar_url</td>";
	print "<td>$timestamp</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);
 
// cleanup
mysqli_close($conn);

?>

<hr>
<i>Hope you enjoyed!<br>BeamBeamPalace, Inc.</i>
<br><br>
<form>
 <input type="button" value="It's Home Time!" onclick="window.location.href = 'index.html';">
</form>

</body>
</html>
	  
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
  <title>Beam Userlist</title>
  </head>
  
  <body bgcolor="white">
  
  
  <h1>Beam Userlist</h1><hr>
  
  
<?php
 
$query = "SELECT username, avatar_url, timestamp FROM user;";
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

$row_count = mysqli_num_rows($query);

print "The Beam service is empowered by <b>$row_count brilliant members!</b><br>(And counting!!)";

while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	print "<br>";
    print "$row[username]  $row[avatar_url]  $row[timestamp]";
}

mysqli_free_result($result);

mysqli_close($conn);

?>

</body>
</html>
	  
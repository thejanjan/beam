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
 
$query = "SELECT * FROM user;";
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	print "\n";
    print "$row[username]  $row[avatar_url]";
}

mysqli_free_result($result);

mysqli_close($conn);

?>

</body>
</html>
	  
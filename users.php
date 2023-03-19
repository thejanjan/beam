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
 
$query = "SELECT username, avatar_url, timestamp FROM user REVERSE ORDER BY timestamp;";
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

$row_count = mysqli_num_rows($result);

print "The Beam service is empowered by <b>$row_count brilliant members!</b><br>(And counting!!)";
print "<br><h4>All Members</h4>";
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>User</th><th>Join Date</th><th>Avatar</th><th>Account Page</th>";

$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>User #$index:<br>$row[username]</td>";
	print "<td>Joined the Beam Family<br>$row[timestamp]</td>";
	print "<td><p><iframe style='width: 100px; height: 100px; overflow: hidden;' src='$row[avatar_url]' width='100' height='100' scrolling='no'>Iframes not supported</iframe></p></td>";
	print "<td><a title='Account' href='account.php?a=$row[username]'>Go to Account</a></td>";
	print "</tr>";
}

print "</tbody></table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<hr>
<i>That is it I am all out of users Sorry</i>
<br>
    <form>
        <input type="button" value="Take Me Back" onclick="history.back()">
    </form>

</body>
</html>
	  
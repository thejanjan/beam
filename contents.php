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
print "<hr><h2>user</h2>";
$query = "SELECT username, avatar_url, timestamp FROM user;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>username</th><th>avatar_url</th><th>timestamp</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[username]</td>";
	print "<td>$row[avatar_url]</td>";
	print "<td>$row[timestamp]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Friend Status Table
print "<hr><h2>friendstatus</h2>";
$query = "SELECT user_a, user_b, status FROM friendstatus;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>user_a</th><th>user_b</th><th>status</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[user_a]</td>";
	print "<td>$row[user_b]</td>";
	print "<td>$row[status]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Private Message Table
print "<hr><h2>privatemessage</h2>";
$query = "SELECT message_id, sender, receiver, message, timestamp FROM privatemessage;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>message_id</th><th>sender</th><th>receiver</th><th>message</th><th>timestamp</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[message_id]</td>";
	print "<td>$row[sender]</td>";
	print "<td>$row[receiver]</td>";
	print "<td>$row[message]</td>";
	print "<td>$row[timestamp]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Game Table
print "<hr><h2>game</h2>";
$query = "SELECT game_id, name, description, releasedate, cost, publisher, developer, website, image FROM game;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>game_id</th><th>name</th><th>description</th><th>releasedate</th><th>cost</th><th>publisher</th><th>developer</th><th>website</th><th>image</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[game_id]</td>";
	print "<td>$row[name]</td>";
	print "<td>$row[description]</td>";
	print "<td>$row[releasedate]</td>";
	print "<td>$row[cost]</td>";
	print "<td>$row[publisher]</td>";
	print "<td>$row[developer]</td>";
	print "<td>$row[website]</td>";
	print "<td>$row[image]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Review Table
print "<hr><h2>review</h2>";
$query = "SELECT review_id, game_id, username, rating, description, timestamp FROM review;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>review_id</th><th>game_id</th><th>username</th><th>rating</th><th>description</th><th>timestamp</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[review_id]</td>";
	print "<td>$row[game_id]</td>";
	print "<td>$row[username]</td>";
	print "<td>$row[rating]</td>";
	print "<td>$row[description]</td>";
	print "<td>$row[timestamp]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Review Rating Table
print "<hr><h2>reviewrating</h2>";
$query = "SELECT review_id, rater_name, rating FROM reviewrating;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>review_id</th><th>rater_name</th><th>rating</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[review_id]</td>";
	print "<td>$row[rater_name]</td>";
	print "<td>$row[rating]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Topic Table
print "<hr><h2>topic</h2>";
$query = "SELECT topic_id, game_id, username, topic_name, timestamp FROM topic;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>topic_id</th><th>game_id</th><th>username</th><th>topic_name</th><th>timestamp</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[topic_id]</td>";
	print "<td>$row[game_id]</td>";
	print "<td>$row[username]</td>";
	print "<td>$row[topic_name]</td>";
	print "<td>$row[timestamp]</td>";
	print "</tr>";
}
print "</tbody></table>";
mysqli_free_result($result);

// Post Table
print "<hr><h2>topic</h2>";
$query = "SELECT post_id, topic_id, username, message, timestamp FROM post;";
$result = mysqli_query($conn, $query);
print "<table border='1' cellpadding = '5' cellspacing = '5'><tbody>";
print "<th>index</th><th>post_id</th><th>topic_id</th><th>username</th><th>message</th><th>timestamp</th>";
$index = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$index = $index + 1;
	print "<tr>";
	print "<td>$index</td>";
	print "<td>$row[post_id]</td>";
	print "<td>$row[topic_id]</td>";
	print "<td>$row[username]</td>";
	print "<td>$row[message]</td>";
	print "<td>$row[timestamp]</td>";
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
	  
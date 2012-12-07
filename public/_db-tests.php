<?php

require_once("../includes/database.php");
require_once("../includes/user.php");

if(isset($database)) {echo "true";} else {echo "false";}
echo "<br>";
echo $database->escape_value("It's working");
echo "<br>";

$sql = "INSERT INTO users (id, username, password, first_name, last_name) ";
$sql .= "VALUES (1, 'towermedia', 'Global003!', 'Ryan', 'Hightower')";
//$result = $database->query($sql);

$sql = "SELECT * FROM users WHERE id=1";
$result_set = $database->query($sql);
$found_user = $database->fetch_array($result_set);
echo $found_user["username"];

echo "<hr>";

$found_user = User::find_by_id(1);
echo $found_user['username'];

echo "<hr>";

$user_set = User::find_all();
while($user = $database->fetch_array($user_set)){
	echo "Username: ".$user['username']."<br />";
	echo "Name: ".$user['first_name']." ".$user['last_name']."<br />";
}
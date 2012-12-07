<?php

require_once("../includes/initialize.php");

?>

<?php include_layout_template('header.php'); ?>

<h1>Welcome to the Photo Gallery!</h1>

<?php
$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr>";

$users = User::find_all();
foreach($users as $user){
	echo "Username: ".$user->username."<br />";
	echo "Password: ".$user->password."<br />";
	echo "Name: ".$user->full_name()."<br />";
}
?>

<?php include_layout_template('footer.php'); ?>
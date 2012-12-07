<?php

require_once("../../includes/initialize.php");


//if( $session->is_logged_in()) { redirect_to("index.php"); }

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	// Check database to see if username/password exist.
	
	$found_user = User::authenticate($username, $password);
	
	if($found_user) {
		Logger::log_action('login',$username." logged in.");
		$session->login($found_user);
		redirect_to("index.php");
	} else {
		// username/password combo was not found in the database.
		Logger::log_action('invalid login',$username." attempted log in.");
		$message = "Username/password combination incorrect.";
	}
} else { // Form has not been submitted.
	$username = "";
	$password = "";
}

if ($_GET['logout']==true) {
//	echo $_GET['logout'];
	if($session->logout()){
		Logger::log_action('Logout',$username." logged out.");
	}
			//Logger::log_action('Logout',$username." logged out 2.");
}
?>

<?php include_layout_template('admin_header.php'); ?>


			<h2>Staff Login</h2>
			<?php echo output_message($message); ?>
			
			<form action="login.php" method="post">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" name="submit" value="Login" />
						</td>
					</tr>
				</table>
			</form>
			<br />
			<!--
<form action="login.php" method="post">
				<input type="hidden" name="logvalue" value="log" />
				<input type="submit" name="submit2" value="Log">
			</form>
-->

<?php include_layout_template('admin_footer.php'); ?>
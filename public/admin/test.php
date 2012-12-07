<?php

/***************************
* Admin Index
***************************/

require_once("../../includes/initialize.php");

if( !$session->is_logged_in()) { redirect_to("login.php"); }


$appId = "<your Bing appId>";
$fromLang = "en";
$translatedText = "";
if (isset($_POST)) {
	$tobetranslated = $_POST["tobeTranslated"];
	$toLang = $_POST["languageChoice"];

	if (tobetranslated == "") {
		echo '<p style="color:red;">Please enter text to be translated!</p>';
	} else {
		$uri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?appId="
		+ $appId + "&text=" + $tobetranslated + "&from=" + $fromLang + "&to=" + $toLang;
		
		/*
HttpWebRequest request = (HttpWebRequest)WebRequest.Create(uri);
		WebResponse response = request.GetResponse();
		Stream strm = response.GetResponseStream();
		StreamReader reader = new System.IO.StreamReader(strm);
		translatedText = reader.ReadToEnd();
		Response.Write("The translated text is: '" + translatedText + "'.");
		response.Close();
*/
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>
		<h2>Menu</h2>
		<ul>
			<li><a href="logfile.php">Check Log file</a></li>
		</ul>

<?php 
/* WORKING*/
	/*
$user = new User();

	$user->username = "johnsmith";
	$user->password = "pass123";
	$user->first_name = "John";
	$user->last_name = "Smith";
	$user->save(); //was $user->create();

	
*/

/*
	if($user = User::find_by_id(3)){
// 	$user = User::find_by_sql("SELECT * FROM users WHERE id=2 LIMIT 1"); 
	
	echo "<pre>";
	print_r($user);
	echo "</pre>";
	
	$user->password = "abcd1234";
	
	echo "<pre>";
	print_r($user);
	echo "</pre>";

	$user->save(); //was $user->update();
	} else {
		echo "User does not exist";
	}
*/
	
	
/* 	$user->delete(); */

/* 
//CREATE PHOTOGRAPH DATABASE TABLE

$query = "CREATE TABLE photographs (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
filename VARCHAR(255) NOT NULL,
type VARCHAR(100) NOT NULL,
size INT(11) NOT NULL,
caption VARCHAR(255) NOT NULL
)";
$database->query($query);
*/

//TEST Photograph attach_file();

$form = "<form action='test.php' method='post'>";
?>

<h1>Using Windows Live Translator's HTTP API</h1>
<form method="post" action="">
	<div>
		<label for="tobeTranslated">Type the text you want translated:</label>
		<br />
		<textarea name="tobeTranslated" rows="5" cols="20" id="inputText" />
		</textarea>
	</div>
	I want to translate to:
	<select name="languageChoice">
		<option value="es" >Spanish</option>
		<option value="fr">French</option>
		<option value="it">Italian</option>
	</select>
	<input type="submit" value="Translate Now!" />
</form>
<?php include_layout_template('admin_footer.php'); ?>
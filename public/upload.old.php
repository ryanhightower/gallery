<?php

require_once("../includes/initialize.php");

// In an application, this could be moved to a config file
$upload_errors = array(
	UPLOAD_ERR_OK			=> "No errors.",
	UPLOAD_ERR_INI_SIZE		=> "Larger than upload_max_filesize.",
	UPLOAD_ERR_FORM_SIZE	=> "Larger than form MAX_FILE_SIZE.",
	UPLOAD_ERR_PARTIAL		=> "Partial upload.",
	UPLOAD_ERR_NO_FILE		=> "No file.",
	UPLOAD_ERR_NO_TMP_DIR	=> "No temporary directory.",
	UPLOAD_ERR_CANT_WRITE	=> "Can't write to disk.",
	UPLOAD_ERR_EXTENSION	=> "File upload stopped by extension."
);

if(isset($_POST['submit'])){
	// process form data
	$tmp_file = $_FILES['file_upload']['tmp_name'];
	$target_file = basename($_FILES['file_upload']['name']);
	$upload_dir = dirname(__FILE__)."/uploads";
	
/* 	You will probably want to first use file_exists() to make sure
 there isn't already a file by the same name. */
 
/* move_uploaded_file will return false if $tmp_file is not a valid file
or if it cannot be moved for any other reason. */

	if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)){
		$message = "File uploaded successfully.";
	} else {
		$error = $_FILES['file_upload']['error'];
		$message = $upload_errors[$error];
	}
}
	echo $upload_dir;
	echo "<pre>";
	print_r($_FILES['file_upload']);
	echo "</pre>";
	echo "<hr />";
?>
<html>
	<head></head>
	<body>
	<?php
		/* NOTE: The maximum file size (in bytes) must be declared before the file input field and can't be larger than the setting for upload_max_filesize in php.ini.
			1 Megabyte is actually 1,048,576 bytes.
		*/
	?>
		<?php if(!empty($message)){echo"<p>{$message}</p>";} ?>
		<form action="upload.php" enctype="multipart/form-data" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="67108864" />
			<input type="file" name="file_upload" />
			<input type="submit" name="submit" value="upload" />
		</form>
	</body>
</html>
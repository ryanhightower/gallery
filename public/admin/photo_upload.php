<?php
require_once('../../includes/initialize.php');
if(!$session->is_logged_in()) {redirect_to("login.php");}
?>
<?php 
	//$max_file_size = 67108864;
	
	$message = "";
	if(isset($_POST['submit'])){
		$photo = new Photograph();
		$photo->caption = $_POST['caption'];
		$photo->attach_file($_FILES['file_upload']);
		if($photo->save()){
			$message = "Photograph was uploaded successfully";
		} else {
			$message = join("<br />", $photo->errors);
		}
	}
?>

<?php include_layout_template('admin_header.php'); ?>	

<h2>Photo Upload</h2>
		<?php if(!empty($message)){echo output_message($message);} ?>
		<form action="" enctype="multipart/form-data" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
			<p><input type="file" name="file_upload" /></p>
			<p>Caption: <input type="text" name="caption" value="" /></p>
			<input type="submit" name="submit" value="upload" />
		</form>
		
<?php include_layout_template('admin_footer.php'); ?>
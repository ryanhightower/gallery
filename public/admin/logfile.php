<?php
require_once("../../includes/initialize.php");

$log=SITE_ROOT.DS."logs".DS."log.txt";
if($_GET['clear']=='true'){
	if(file_exists($log)){
		file_put_contents($log, '');
		Logger::log_action("Log Cleared", " by user id {$session->user_id}.");	
		redirect_to('logfile.php');
	}
}

	if( !$session->is_logged_in()) { redirect_to("login.php"); }
	
	
	?>
	
	<?php include_layout_template('admin_header.php'); ?>
	<a href="index.php">&laquo;Back</a>
		<h2>Log File</h2>
<?php
	if( file_exists($log) && is_writable($log) && $handle = fopen($log, 'r')){	
			echo "<ul class=\"log-entries\">";
			while(!feof($handle)){
				$entry = fgets($handle); // reads each LINE incrementally.
				if(trim($entry)!=""){
					echo '<li>'.$entry.'</li>';
				}
			} 
			fclose($handle);
			echo "</ul>";
		} else {
			echo "Not writable. Check your permissions.";
		}
?>				
	<a href="logfile.php?clear=true">Clear log file</a>
	<?php include_layout_template('admin_footer.php'); ?>
	
	
	
	
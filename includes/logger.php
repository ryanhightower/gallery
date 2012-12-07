<?php
// LOGGER FUNCTIONS

class Logger {
	
	public $path_to_logs;
	public $log;
	
	public static function log_action($action, $message=""){
		
		$path_to_logs = SITE_ROOT.DS.'logs';	
		$log = $path_to_logs.DS."log.txt";
		
		$new = file_exists($log) ? false : true;

		if($handle=fopen($log, 'a')){
			$timestamp = strftime("%Y-%m-%d %H:%M:%S",time());
			$content = "{$timestamp} | {$action}: {$message}\n";
			fwrite($handle, $content);
			fclose($handle);	
			if($new){chmod($log, 0755);}
		} else{
			output_message("Log file is not writable.");
		}
	 	 
	 	 
	}
	
}

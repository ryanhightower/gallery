<?php
// If it's going to need the database, then it's probably smart to require it before we start.
require_once(LIB_PATH.DS."database.php");

class User extends DBObject {
	
	protected static $table_name="users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name');
	
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	
	
	public function full_name(){
		if(isset($this->first_name)&&isset($this->last_name)){
			return $this->first_name." ".$this->last_name;
		} else {
			return "";
		}
	}
	
	public static function authenticate($username="", $password=""){
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
	
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
/*  // ADDED TO DBOBJECT.
	public function save(){
		// A new record won't have an id yet.
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	protected function create(){
		global $database;
// 		Don't forget your SQL syntax and good habits: 
//		- INSERT INTO table (key, key) VALUES ('value', 'value')
//		- single-quotes around all values
//		- escape all values to prevent SQL injection

		$sql = "INSERT INTO ".self::$table_name." (";
		$sql .= "username, password, first_name, last_name";
		$sql .= ") VALUES ('";
		$sql.= $database->escape_value($this->username)."', '";
		$sql.= $database->escape_value($this->password)."', '";
		$sql.= $database->escape_value($this->first_name)."', '";
		$sql.= $database->escape_value($this->last_name)."')";
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	protected function update(){
		global $database;
//		Don't forget your SQL syntax and good habits: 
//		- INSERT INTO table (key, key) VALUES ('value', 'value')
//		- single-quotes around all values
//		- escape all values to prevent SQL injection

		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= "username='".$database->escape_value($this->username)."', ";
		$sql .= "password='".$database->escape_value($this->password)."', ";
		$sql .= "first_name='".$database->escape_value($this->first_name)."', ";
		$sql .= "last_name='".$database->escape_value($this->last_name)."' ";
		$sql .= "WHERE id=".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false; 
		
	}
	
	public function delete(){
		global $database;
// 		Don't forget your SQL syntax and good habits: 
//		- DELETE FROM table WHERE condition LIMIT 1
//		- escape all values to prevent SQL injection
//		- use LIMIT 1

		$sql = "DELETE FROM ".self::$table_name." ";
		$sql .= "WHERE id=".$database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows()==1)? true : false;
	}
*/
	

// Common Database Methods
	
/* 
// NOTICE: These functions moved to DBObject for use with PHP 5.3. Uncomment in case of PHP 5.2

	public static function find_all(){
		global $database;
		$object = self::find_by_sql("SELECT * FROM ".self::$table_name);
		return $object;
		
	}	
	
	public static function find_by_id($id=0){
		global $database;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		//$found = $database->fetch_array($result_set);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	private static function instantiate($record){
		$object = new self;
		
		//More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}

		return $object;
	}
	
	private function has_attribute($attribute){
		//get_object_vars returns an associateive array with all attributes
		//(incl. private ones!) as the keys and their current values as the value
		$object_vars = get_object_vars($this);
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false.
		return array_key_exists($attribute, $object_vars);
	}
*/
	
}
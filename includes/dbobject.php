<?php 

require_once(LIB_PATH.DS.'database.php');

class DBObject {

// Common Database Methods

// NOTICE: These functions use static methods that require PHP 5.3. Comment them out in case of PHP 5.2
	
	public static function find_all(){
		global $database;
		$object = static::find_by_sql("SELECT * FROM ".static::$table_name);
		return $object;
		
	}	
	
	public static function find_by_id($id=0){
		global $database;
		$query = "SELECT * FROM ";
		$query .= static::$table_name;
		$query .= " WHERE id={$id} LIMIT 1";
		/* echo $query; */
		$result_array = static::find_by_sql("SELECT * FROM users WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)){
			$object_array[] = static::instantiate($row);
		}
		return $object_array;
	}
	
	private static function instantiate($record){
		$object = new static;
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}

		return $object;
	}
	
	private function has_attribute($attribute){
		// get_object_vars returns an associateive array with all attributes
		// (incl. private ones!) as the keys and their current values as the value
		
		// $object_vars = get_object_vars($this);
		$object_vars = $this->attributes();
		
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false.
		return array_key_exists($attribute, $object_vars);
	}
	
	protected function attributes(){
		// return an array of aatribute keys and their values
		//return get_object_vars($this);
		
		$attributes = array();
		foreach(static::$db_fields as $field){
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		}
		
		return $attributes;
	}
	
	protected function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		// sanitize the values before submitting
		// NOTE: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}
	
	public function save(){
		// A new record won't have an id yet.
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	protected function create(){
		global $database;
/* 		Don't forget your SQL syntax and good habits: 
		- INSERT INTO table (key, key) VALUES ('value', 'value')
		- single-quotes around all values
		- escape all values to prevent SQL injection
*/
		$attributes = $this->sanitized_attributes();
		
		$sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes)); // "username, password, first_name, last_name";
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
/*
		$sql.= $database->escape_value($this->username)."', '";
		$sql.= $database->escape_value($this->password)."', '";
		$sql.= $database->escape_value($this->first_name)."', '";
		$sql.= $database->escape_value($this->last_name)."')";
*/
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	protected function update(){
		global $database;
/* 		Don't forget your SQL syntax and good habits: 
		- INSERT INTO table (key, key) VALUES ('value', 'value')
		- single-quotes around all values
		- escape all values to prevent SQL injection
*/
		$attributes = $this->sanitized_attributes();
		foreach($attributes as $key => $value){
			$attribute_pairs[]="{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
/*
		$sql .= "username='".$database->escape_value($this->username)."', ";
		$sql .= "password='".$database->escape_value($this->password)."', ";
		$sql .= "first_name='".$database->escape_value($this->first_name)."', ";
		$sql .= "last_name='".$database->escape_value($this->last_name)."'";
*/
		$sql .= " WHERE id=".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false; 
		
	}
	
	public function delete(){
		global $database;
/* 		Don't forget your SQL syntax and good habits: 
		- DELETE FROM table WHERE condition LIMIT 1
		- escape all values to prevent SQL injection
		- use LIMIT 1
*/
		$sql = "DELETE FROM ".static::$table_name." ";
		$sql .= "WHERE id=".$database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows()==1)? true : false;
	}
	
}
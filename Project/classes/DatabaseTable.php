<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/3/2018
 * Time: 2:54 PM
 */

class DatabaseTable {
	
	private $pdo;
	private $table;
	private $primKey;
	
	/**
	 * DatabaseTable constructor.
	 *
	 * @param PDO $pdo: Reference to PHP Built-in PDO class
	 * @param string $table: The name of the table which we are going to do operation on it
	 * @param string $primKey: The label of the primary key of the table
	 */
	public function __construct(PDO $pdo, string $table, string $primKey) {
		$this -> pdo = $pdo;
		$this -> table = $table;
		$this -> primKey = $primKey;
	}
	
	private function query($query, $params = []) {
		$stmt = $this -> pdo -> prepare ($query);
		$stmt -> execute ($params);
		return $stmt;
	}
	
	public function total() {
		$q = $this -> query ('SELECT COUNT(*) FROM '. $this -> table);
		$row = $q -> fetch ();
		return $row[0];
	}
	
	public function findById($id) {
		$q = 'SELECT * FROM `' .$this -> table. '` WHERE `' .$this -> primKey. '` = :id';
		$params = ['id' => $id];
		$q = $this -> query ($q, $params);
		return $q -> fetch ();
	}
	
	private function findMaxId() {
		$q = 'SELECT MAX(id) FROM `'. $this -> table. '`';
		$q = $this -> query($q);
		return $q -> fetch();
	}
	
	private function insert($fields) {
		$q = 'INSERT INTO `'. $this -> table. '` (';
		
		foreach ($fields as $key => $value) {
			$q .= '`' .$key. '`,';
		}
		
		$q = rtrim($q, ',');
		$q .= ') VALUES (';
		
		// We use ':' concat with $key as the placeholders for prepared statement query
		foreach ($fields as $key => $value) {
			$q .= ':' .$key. ',';
		}
		
		$q = rtrim($q, ',');
		$q .= ')';
		
		$fields = $this -> processDates ($fields);
		
		$this -> query ($q, $fields);
	}
	
	private function update($fields) {
		$q = 'UPDATE `' .$this -> table. '` SET ';
		
		foreach ($fields as $key => $value) {
			$q .= '`' .$key. '` = :' .$key. ',';
		}
		
		$q = rtrim($q, ',');
		
		$q .= ' WHERE `' .$this -> primKey. '` = :primKey';
		
		// Set the primKey variable
		$fields['primKey'] = $fields['id'];
		
		$fields = $this -> processDates ($fields);
		
		$this -> query ($q, $fields);
	}
	
	public function delete($id) {
		$params = [':id' => $id];
		$this -> query ('DELETE FROM `' .$this -> table. '` WHERE `' .$this -> primKey. '` = :id', $params);
	}
	
	public function findAll() {
		$r = $this->query('SELECT * FROM ' .$this -> table);
		return $r -> fetchAll();
	}
	
	private function processDates($fields) {
		foreach ($fields as $key => $value) {
			if($value instanceof DateTime) {
				$fields[$key] = $value -> format('Y-m-d');
			}
		}
		return $fields;
	}
	
	public function save($record) {
		/*
		 * If the primary key value provided by the $record exists in the table,
		 * then it's an insert action.
		 */
		try {
			if($record[$this -> primKey] == '') {
				// Get max id number and add it by 1 and save it a new primary key value
				$record[$this -> primKey] = $this -> findMaxId()[0] + 1;
			}
			$this -> insert($record);
		}
		
		/*
		 * The insert action wasn't successful, it's because the primary key value provided by the $record exists in the table,
		 * (DUPLICATE KEY)
		 * so it's an update action which should use the existing primary key value.
		 */
		catch (PDOException $e) {
			$this -> update($record);
		}
	}
}
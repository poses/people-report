<?php
	/**
	 * Model :: Use for connect database.
	 *
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */
	class Model {

    	public function connect() {
    		global $db;
    		//Connect database use `PDO`;
    		try {
	    		return new PDO('mysql:host=localhost;dbname=people', 'root', 'root');
    		} catch( PDOException $e ) {
				echo 'ERROR! : ' . $e->getMessage();
    		}
    	}

    	/**
    	 * Get all content from table
    	 *
    	 * @param String $table Table that you want to get data.
    	 * @return Array All data in that table.
    	 * @author Ting <ichaiwut.s@gmail.com>
    	 * @since 9 July 2013
    	 */
    	public function findAll( $table ) {
    		$data = $this->connect();
    		//Set collation to `utf8` if import database
    		//from another database.
    		$data->query('SET NAMES utf8');
    		return $data->query('SELECT * FROM ' . $table);
    	}
	}
?>
<?php
	/**
	 * Model :: Use for connect database.
	 *
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */
	class Model {

    	public function connect() {
    		// global $db;
    		try {
	    		return new PDO('mysql:host=localhost;dbname=people', 'root', 'root');
    		} catch( PDOException $e ) {
				echo 'ERROR! : ' . $e->getMessage();
    		}
    	}

    	public function findAll() {
    		$data = $this->connect();
    		return $data->query('SELECT * FROM faceacc_access_type');
    	}
	}
?>
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
    	 * Get content from table by usig `BETWEEN`
    	 *
         * @param String $table Table that you want to get data.
         * @param String $field field name that you want to get data.
         * @param String $startDate start date
    	 * @param String $endDate end date
    	 * @return Array All data in the table.
    	 * @author Ting <ichaiwut.s@gmail.com>
    	 * @since 9 July 2013
    	 */
    	public function findWithDate( $table, $field, $startDate, $endDate ) {
    		$data = $this->connect();
    		//Set collation to `utf8` if import database
    		//from another database.
    		$data->query('SET NAMES utf8');
            //Get data from database by use `BETWEEN`
            $sql = "SELECT * FROM $table
                    WHERE $field BETWEEN '$startDate' AND '$endDate'";

            return $data->query($sql);
    	}
	}
?>
<?php
	/**
	 * Model :: Use for connect database.
	 *
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */
	class Model {
        /**
         * Connect database using `PDO`
         * @author Ting <ichaiwut.s@gmail.com>
         */
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
         * @param  String $table table name.
         * @return array - array of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
    	public function findAll( $table ) {
            $data = $this->connect();
    		$data->query('SET NAMES utf8');
            $sql = "SELECT * FROM $table";
            return $data->query($sql);
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
         */
        public function findWithDate( $table, $field, $startDate, $endDate ) {
            $data = $this->connect();
            //Set collation to `utf8` if import database
            //from another database.
            $data->query('SET NAMES utf8');
            //Get data from database by use `BETWEEN`
            $sql = "SELECT * FROM $table
                    WHERE $field BETWEEN '$startDate' AND '$endDate' LIMIT 10";

            return $data->query($sql);
        }

        /**
         * File data in tabel using id to referrent.
         *
         * @param  String $table Table's name.
         * @param  Integer $id   id for referrent
         * @return Array All data in tabel
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findById( $table, $id ) {
            $data = $this->connect();
            $data->query('SET NAMES utf8');

            $sql = "SELECT * FROM $table
                    INNER JOIN faceacc_log_sumperday ON
                    faceacc_log_sumperday.officer_id=faceacc_officer.officer_id
                    WHERE faceacc_log_sumperday.officer_id='$id'";

            $userData = $data->query($sql);

            //Arrange value in to array.
            $user = array();
            foreach ($userData as $vUser) {
                $user[] = $vUser;
            }
            return $user;
        }
	}
?>
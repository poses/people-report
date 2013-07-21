<?php
	/**
	 * Model :: Use for connect database.
	 * @package Maximize by 3Musketters
     * @version 1.0
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
         * @param String $limit limit to query
         * @return Array All data in the table.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findWithDate( $table, $table2, $field, $startDate, $endDate, $limit ) {
            $data = $this->connect();
            //Set collation to `utf8` if import database
            //from another database.
            $data->query('SET NAMES utf8');
            //Get data from database by use `BETWEEN`
            $sql = "SELECT * FROM $table INNER JOIN $table2 ON
                    $table.officer_id=$table2.officer_id
                    INNER JOIN tbl_prename ON $table.prename=tbl_prename.id
                    WHERE $field BETWEEN '$startDate' AND '$endDate'
                    $limit";

            return $data->query($sql);
        }

        /**
         * Fidd all user with `prename` of user.
         *
         * @param  boolean $count will use `SELECT COUNT(*)` if value is TURE.
         * @param  String $limit use for set `LIMIT` for mysql.
         * @return Array group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findOfficer( $count = false, $limit = '' ) {
            //Ceck `$count` for select **All** or select **COUNT**.
            //Use `SELECT COUNT(*)` for paginate the result.
            $count = ($count) ? 'COUNT(*)' : '*';

            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sql = "SELECT $count FROM faceacc_officer INNER JOIN tbl_prename ON
                    faceacc_officer.prename=tbl_prename.id
                    ORDER BY faceacc_officer.officer_id ASC
                    $limit";

            return $data->query($sql);
        }

        /**
         * Get number fo allowed day-off
         *
         * @return integer $dataLimit nomber of allowed times.
         * @author TIng <ichaiwut.s@gmail.com>
         */
        public function findAccessTypeLimit() {
            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $accessLimit = $data->query('SELECT * FROM faceacc_access_type WHERE type_limit <> 0');

            $dataLimit = array();
            foreach ( $accessLimit as $kLimit => $vLimit) {
                $dataLimit[$kLimit] = $vLimit;
            }

            return $dataLimit;
        }

        /**
         * Count late on each person
         *
         * @param  integer $officerId person id.
         * @param  date $startDate start date.
         * @param  date $endDate   end date.
         * @return integer number of allowed times.
         * @author Ting <iChaiwut.s@gmail.com>
         */
        public function latePerTimes( $officerId, $startDate, $endDate ) {
            $data = $this->connect();
            $sql = "SELECT COUNT(*) FROM faceacc_log_sumperday
                    WHERE officer_id=$officerId
                    AND time_late<>0
                    AND logDate BETWEEN '$startDate' AND '$endDate'
                    ";

            $timeLate = $data->query($sql);
            return $timeLate->fetchColumn();
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
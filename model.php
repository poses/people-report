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
         * Fidd all user with `prename` of user.
         *
         * @param  boolean $count will use `SELECT COUNT(*)` if value is TURE.
         * @param  String $limit use for set `LIMIT` for mysql.
         * @return Array group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findOfficer( $count = false, $position, $limit = '' ) {
            //Ceck `$count` for select **All** or select **COUNT**.
            //Use `SELECT COUNT(*)` for paginate the result.
            $count = ($count) ? 'COUNT(*)' : '*';
            $position = empty($position) ? '' : ' AND position_name=' . $position;

            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sql = "SELECT $count FROM faceacc_officer
                    INNER JOIN tbl_prename ON
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
            $accessLimit = $data->query('SELECT * FROM faceacc_access_type WHERE type_limit <> 0 OR access_type_id = 1');

            $dataLimit = array();
            foreach ( $accessLimit as $kLimit => $vLimit) {
                $dataLimit[$vLimit['access_type_id']] = $vLimit;
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
         * Calculate minute of day-off for each person
         *
         * @param  integer $officerId person id.
         * @param  date $startDate start date.
         * @param  date $endDate   end date.
         * @return integer number of minute (time stamps)
         * @author Ting <iChaiwut.s@gmail.com>
         */
        public function latePerMinute( $officerId, $startDate, $endDate ) {
            $data = $this->connect();
            $sql = "SELECT time_late FROM faceacc_log_sumperday
                    WHERE officer_id=$officerId
                    AND logDate BETWEEN '$startDate' AND '$endDate'
                    ";
            $allMinutes = $data->query($sql);
            //Mix value of time.
            $timeMinute = 0;
            foreach ( $allMinutes as $vMinute ) {
                $timeMinute += $vMinute['time_late'];
            }

            return $timeMinute;
        }

        /**
         * Get all late of user in each type.
         *
         * @param  int $officerId user id.
         * @param  date $startDate start date.
         * @param  date $endDate end date.
         * @return arary group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function lateWithType( $officerId, $startDate, $endDate ) {
            $data = $this->connect();
            $sql = "SELECT * FROM faceacc_log_sumperday
                    WHERE officer_id=$officerId
                    AND access_type_id<>3
                    AND logDate BETWEEN '$startDate' AND '$endDate'
                    ";

            $dayOffType = $data->query($sql);

            $type = array();
            foreach ($dayOffType as $kType => $vType) {
                $type[$kType] = $vType['access_type_id'];
            }

            return $type;
        }

        /**
         * Get position of user
         *
         * @param  integer $id user id
         * @return string return position name.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function getPosition( $id ) {
            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sql = "SELECT position_name FROM faceacc_log_sumperday
                    WHERE officer_id=$id
                    ORDER BY officer_id DESC
                    LIMIT 1
                ";

            $sth = $data->prepare($sql);
            $sth->execute();
            $positionName = $sth->fetchAll(PDO::FETCH_ASSOC);
            $position = $positionName[0]['position_name'];

            return $position;
        }

        public function getAllPosition() {
            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sql = "SELECT distinct(position_name) FROM faceacc_log_sumperday";
            $sth = $data->prepare($sql);
            $sth->execute();
            $allPositionName = $sth->fetchAll(PDO::FETCH_ASSOC);

            return $allPositionName;
        }

        /**
         * File data in tabel using id to referrent.
         *
         * @param  Integer $id   id for referrent
         * @return Array All data in tabel
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findById( $id ) {
            $data = $this->connect();
            $data->query('SET NAMES utf8');

            $sql = "SELECT * FROM faceacc_officer INNER JOIN tbl_prename ON
                    faceacc_officer.prename=tbl_prename.id
                    WHERE faceacc_officer.officer_id='$id'";

            $userData = $data->query($sql);

            //Arrange value in to array.
            $user = array();
            foreach ($userData as $vUser) {
                $user[] = $vUser;
            }

            return $user;
        }

        public function getDayOffByUser($id, $accessid, $startDate, $endDate) {
            $data = $this->connect();
            $data->query('SET NAMES utf8');

            $sql = "SELECT * FROM faceacc_log_sumperday
                    WHERE officer_id=$id
                    AND access_type_id=$accessid
                    AND logDate BETWEEN '$startDate' AND '$endDate'
                ";

            $sth = $data->prepare($sql);
            $sth->execute();
            $dayOff = $sth->fetchAll(PDO::FETCH_ASSOC);

            return $dayOff;

        }

        public function findLimitPerYear( $id, $year ) {
            $data = $this->connect();
            $sql = "SELECT * FROM faceacc_officer_access_type_limit
                    WHERE officer_id=$id
                    AND access_type_year='$year'
                    ";
                    // echo $sql; exit();
            $sth = $data->prepare($sql);
            $sth->execute();
            $limitPerYear = $sth->fetchAll(PDO::FETCH_ASSOC);

            foreach ($limitPerYear as $kLimit => $vLimit) {
                $limitPerYear['type-' . $vLimit['access_type_id']] = $vLimit;
                unset($limitPerYear[$kLimit]);
            }

            return $limitPerYear;
        }

        public function addAllAccess( $id, $accessId, $limit, $year ) {
            $data = $this->connect();
            $sql = "INSERT INTO faceacc_officer_access_type_limit (officer_id, access_type_id, access_type_year, access_type_limit, access_type_updatetime)
                    VALUES ($id, $accessId, '$year', $limit, NOW())
                ";
            $sth = $data->prepare($sql);
            $sth->execute();
        }
	}
?>
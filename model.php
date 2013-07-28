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
	    		return new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['database_name'], $db['username'], $db['password']);
    		} catch ( PDOException $e ) {
				echo 'ERROR! : ' . $e->getMessage();
    		}
    	}

        /**
         * Find all user with `prename` of user.
         *
         * @param  boolean $count will use `SELECT COUNT(*)` if value is TURE.
         * @param  String $limit use for set `LIMIT` for mysql.
         * @return Array group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function findOfficer( $count, $limit, $startDate = null, $endDate = null, $employeeCat ) {
            //Ceck `$count` for select **All** or select **COUNT**.
            //Use `SELECT COUNT(*)` for paginate the result.
            $count = ($count) ? 'COUNT(*)' : '*';
            // $position = empty($position) ? '' : ' AND position_name=' . $position;

            if ( !empty($startDate) && !empty($startDate) ) {
                $dateCondition = "AND logDate BETWEEN '$startDate' AND '$endDate'";
            }

            $data = $this->connect();
            $data->query('SET NAMES utf8');

            $sql1 = "SELECT $count FROM faceacc_officer
                    INNER JOIN tbl_prename ON
                    faceacc_officer.prename=tbl_prename.id
                    WHERE faceacc_officer.office=$employeeCat
                    ORDER BY faceacc_officer.officer_id ASC
                    $limit";

            return $data->query($sql1);
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

        /**
         * Get all position name.
         * @return array position data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function getAllPosition() {
            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sth = $data->prepare('SELECT distinct(position_name), position_id FROM faceacc_log_sumperday');
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getSiteName( $id = null ) {
            //If user send `$id` will file last site name of user.
            $condition = (empty($id) ? '' : "WHERE officer_id=$id ORDER BY logDate DESC");
            $data = $this->connect();
            $data->query('SET NAMES utf8');
            $sql = "SELECT distinct(site_name) FROM faceacc_log_sumperday $condition";
            $sth = $data->prepare($sql);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
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

            $sth = $data->prepare($sql);
            $sth->execute();
            $user = $sth->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        /**
         * Get day off for each user and each limit type.
         * @param  integer $id user id.
         * @param  integer $accessid limit type id.
         * @param  string $startDate start date.
         * @param  string $endDate end date.
         * @return array group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
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

        /**
         * Get limit data in the year.
         * @param  integer $id  user id.
         * @param  string $year year
         * @return group of limit type data.
         * @author Ting <iChaiwut.s@gmail.com>
         */
        public function findLimitPerYear( $id, $year ) {
            $data = $this->connect();
            $sql = "SELECT * FROM faceacc_officer_access_type_limit
                    WHERE officer_id=$id
                    AND access_type_year='$year'
                    ";

            $sth = $data->prepare($sql);
            $sth->execute();
            $limitPerYear = $sth->fetchAll(PDO::FETCH_ASSOC);

            foreach ($limitPerYear as $kLimit => $vLimit) {
                $limitPerYear['type-' . $vLimit['access_type_id']] = $vLimit;
                unset($limitPerYear[$kLimit]);
            }

            return $limitPerYear;
        }

        /**
         * Add limit value.
         * @param intrger $id user's id.
         * @param integer $accessId access type id.
         * @param string $limit limit value.
         * @param string $year year of limit.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function addAllAccess( $id, $accessId, $limit, $year ) {
            $data = $this->connect();
            //Chanch existing of data.
            $sql = "SELECT * FROM faceacc_officer_access_type_limit
                    WHERE officer_id=$id
                    AND access_type_id=$accessId
                    AND access_type_year='$year'
                    ";
            $sth = $data->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            //If data already exits use `UPDATE` insead of `INSERT`
            if ( !empty($result) ) {
                $sql2 = "UPDATE faceacc_officer_access_type_limit
                         SET access_type_limit=$limit
                         WHERE officer_id=$id
                         AND access_type_id=$accessId
                         AND access_type_year='$year'
                        ";
            } else {
                $sql2 = "INSERT INTO faceacc_officer_access_type_limit (officer_id, access_type_id, access_type_year, access_type_limit, access_type_updatetime)
                         VALUES ($id, $accessId, '$year', $limit, NOW())
                        ";
            }

            $sth = $data->prepare($sql2);
            $sth->execute();
        }

        /**
         * Get limit value of each person
         * @param  integer $id user's id
         * @param  integer $accessId  access type id
         * @param  string $startDate start date.
         * @param  string $endDate end date
         * @return array group of data.
         * @author Ting <ichaiwut.s@gmail.com>
         */
        public function getLimitOfUser( $id, $accessId, $startDate, $endDate ) {
            $data = $this->connect();
            $sql = "SELECT * FROM faceacc_officer_access_type_limit
                    WHERE officer_id=$id
                    AND access_type_id=$accessId
                    AND access_type_year BETWEEN $startDate AND $endDate
                   ";

            $sth = $data->prepare($sql);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
	}
?>
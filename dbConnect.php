<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbConnect
 *
 * @author tabsheer.abdulla
 */
class dbConnect {

    function __construct() {
        require_once('config.php');

        $conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        mysql_select_db(DB_DATABSE, $conn);
        if (!$conn) {// testing the connection  
            die("Cannot connect to the database");
        }
        return $conn;
    }

    public function Close() {
        mysql_close();
    }

}

<?php

class Database {

    public $database;

    const HOST = 'localhost';
    const DB_NAME = 'gym';
    const USERNAME = 'root';
    const PASS = '';
    

    public function __construct() {
        
        $this->database = mysqli_connect(self::HOST, self::USERNAME, self::PASS, self::DB_NAME);

        // Checking if the connection is successful
        if (!$this->database) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
}

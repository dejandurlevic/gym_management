<?php

class AdminUser {
    
    private $username;
    private $hashedPassword;

    public function __construct($username, $hashedPassword) {
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->hashedPassword);
    }
}

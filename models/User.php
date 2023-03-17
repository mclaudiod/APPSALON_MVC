<?php

    namespace Model;

    class User extends ActiveRecord {

        // Database

        protected static $table = "users";
        protected static $dbColumns = ["id", "name", "surname", "email", "password", "phone", "admin", "confirmed", "token"];

        public $id;
        public $name;
        public $surname;
        public $email;
        public $password;
        public $phone;
        public $admin;
        public $confirmed;
        public $token;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->surname = $args["surname"] ?? "";
            $this->email = $args["email"] ?? "";
            $this->password = $args["password"] ?? "";
            $this->phone = $args["phone"] ?? "";
            $this->admin = $args["admin"] ?? "0";
            $this->confirmed = $args["confirmed"] ?? "0";
            $this->token = $args["token"] ?? "";
        }

        // Validation messages for account creation

        public function validateNewAccount() {
            if(!$this->name) {
                self::$alerts["error"][] = "Your name is required";
            };

            if(!$this->surname) {
                self::$alerts["error"][] = "Your surname is required";
            };

            if(!$this->email) {
                self::$alerts["error"][] = "Your e-mail is required";
            };

            if(!$this->password) {
                self::$alerts["error"][] = "A password is required";
            };

            if(strlen($this->password)<6) {
                self::$alerts["error"][] = "Your password must have at least 6 characters";
            };

            return self::$alerts;
        }

        public function validateLogin() {
            if(!$this->email) {
                self::$alerts["error"][] = "The email is required";
            };

            if(!$this->password) {
                self::$alerts["error"][] = "The password is required";
            };

            return self::$alerts;
        }

        public function validateEmail() {
            if(!$this->email) {
                self::$alerts["error"][] = "The email is required";
            };
            
            return self::$alerts;
        }

        public function validatePassword() {
            if(!$this->password) {
                self::$alerts["error"][] = "The password is required";
            };

            if(strlen($this->password)<6) {
                self::$alerts["error"][] = "Your password must have at least 6 characters";
            };
            
            return self::$alerts;
        }

        // Checks if the user exists

        public function userExists() {
            $query = "SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";
            $result = self::$db->query($query);
            
            if($result->num_rows) {
                self::$alerts["error"][] = "The user already exists";
            };

            return $result;
        }

        public function hashPassword() {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

        public function createToken() {
            $this->token = uniqid();
        }

        public function checkPasswordAndVerification($password) {
            $result = password_verify($password, $this->password);

            if(!$result || !$this->confirmed) {
                self::$alerts["error"][] = "Incorrect Password or account not confirmed";
            } else {
                return true;
            };
        }
    };
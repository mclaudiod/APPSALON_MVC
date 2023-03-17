<?php

    namespace Model;

    class Service extends ActiveRecord {

        // Database

        protected static $table = "services";
        protected static $dbColumns = ["id", "name", "price"];

        public $id;
        public $name;
        public $price;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->price = $args["price"] ?? "";
        }

        public function validateService() {
            if(!$this->name) {
                self::$alerts["error"][] = "The name of the service is required";
            };

            if(!$this->price) {
                self::$alerts["error"][] = "The price of the service is required";
            };

            if(!is_numeric($this->price)) {
                self::$alerts["error"][] = "The price of the service must be a number";
            };

            return self::$alerts;
        }
    };
<?php

    namespace Model;
    
    class AppointmentService extends ActiveRecord {

        // Database

        protected static $table = "appointmentsservices";
        protected static $dbColumns = ["id", "appointmentId", "serviceId"];

        public $id;
        public $appointmentId;
        public $serviceId;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->appointmentId = $args["appointmentId"] ?? "";
            $this->serviceId = $args["serviceId"] ?? "";
        }
    };
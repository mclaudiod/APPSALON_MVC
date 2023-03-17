<?php

    namespace Controllers;

    use Model\Appointment;
    use Model\AppointmentService;
    use Model\Service;

    class APIController {
        public static function index() {
            $services = Service::all();
            echo json_encode($services);
        }

        public static function save() {

            // Saves the appointment and returns the id

            $appointment = new Appointment($_POST);
            $result = $appointment->save();

            $id = $result["id"];

            // Saves the appointments and services

            // Saves the services with the id of the appointment

            $servicesId = explode(",", $_POST["services"]);

            foreach( $servicesId as $serviceId) {
                $args = [
                    "appointmentId" => $id,
                    "serviceId" => $serviceId
                ];

                $appointmentService = new AppointmentService($args);
                $appointmentService->save();
            };

            echo json_encode(["result" => $result]);
        }

        public static function delete() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $id = $_POST["id"];
                $appointment = Appointment::find($id);
                $appointment->delete();
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            };
        }
    };
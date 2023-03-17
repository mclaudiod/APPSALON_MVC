<?php

    namespace Controllers;

    use Model\AdminAppointment;
    use MVC\Router;

    class AdminController {
        public static function index(Router $router) {
            session_start();

            isAdmin();

            $date = $_GET["date"] ?? date("Y-m-d");
            $dates = explode("-", $date);

            if(!checkdate($dates[1], $dates[2], $dates[0])) {
                header("Location: /404");
            };

            // Query the database

            $query = "SELECT appointments.id, appointments.time, CONCAT( users.name, ' ', users.surname) as client, ";
            $query .= " users.email, users.phone, services.name as service, services.price  ";
            $query .= " FROM appointments  ";
            $query .= " LEFT OUTER JOIN users ";
            $query .= " ON appointments.userId=users.id  ";
            $query .= " LEFT OUTER JOIN appointmentsservices ";
            $query .= " ON appointmentsservices.appointmentId=appointments.id ";
            $query .= " LEFT OUTER JOIN services ";
            $query .= " ON services.id=appointmentsservices.serviceId ";
            $query .= " WHERE date =  '{$date}' ";
            $query .= " ORDER BY services.price DESC, appointments.time ASC";

            $appointments = AdminAppointment::SQL($query);

            $router->render("admin/index", [
                "name" => $_SESSION["name"],
                "appointments" => $appointments,
                "date" => $date
            ]);
        }
    };
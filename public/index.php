<?php 

    require_once __DIR__ . '/../includes/app.php';

    use Controllers\AdminController;
    use Controllers\LoginController;
    use Controllers\AppointmentController;
    use Controllers\APIController;
    use Controllers\ServiceController;
    use MVC\Router;

    $router = new Router();

    // Login

    $router->get("/", [LoginController::class, "login"]);
    $router->post("/", [LoginController::class, "login"]);
    $router->get("/logout", [LoginController::class, "logout"]);

    // Recover Password

    $router->get("/forgot", [LoginController::class, "forgot"]);
    $router->post("/forgot", [LoginController::class, "forgot"]);
    $router->get("/recover", [LoginController::class, "recover"]);
    $router->post("/recover", [LoginController::class, "recover"]);

    // Create Account

    $router->get("/create-account", [LoginController::class, "create"]);
    $router->post("/create-account", [LoginController::class, "create"]);

    // Confirm Account

    $router->get("/confirm-account", [LoginController::class, "confirm"]);
    $router->get("/message", [LoginController::class, "message"]);

    // Private Area

    $router->get("/appointment", [AppointmentController::class, "index"]);
    $router->get("/admin", [AdminController::class, "index"]);

    // Appointments API

    $router->get("/api/services", [APIController::class, "index"]);
    $router->post("/api/appointments", [APIController::class, "save"]);
    $router->post("/api/delete", [APIController::class, "delete"]);

    // CRUD of Services

    $router->get("/services", [ServiceController::class, "index"]);
    $router->get("/services/create", [ServiceController::class, "create"]);
    $router->post("/services/create", [ServiceController::class, "create"]);
    $router->get("/services/update", [ServiceController::class, "update"]);
    $router->post("/services/update", [ServiceController::class, "update"]);
    $router->post("/services/delete", [ServiceController::class, "delete"]);

    // Verifies and validates the routes, that they exist and asigns them the functions of the Controller

    $router->verifyRoutes();
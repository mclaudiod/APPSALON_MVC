<?php

    namespace Controllers;

    use Model\User;
    use MVC\Router;
    use Classes\Email;

    class LoginController {
        public static function login(Router $router) {

            $alerts = [];

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $auth = new User($_POST);
                $alerts = $auth->validateLogin();

                if(empty($alerts)) {

                    // Check if the user exists

                    $user = User::where("email", $auth->email);

                    if($user) {

                        // Verificate the password

                        if($user->checkPasswordAndVerification($auth->password)) {

                            // Authenticate the user

                            session_start();

                            $_SESSION["id"] = $user->id;
                            $_SESSION["name"] = $user->name . " " . $user->surname;
                            $_SESSION["email"] = $user->email;
                            $_SESSION["login"] = true;

                            // Redirection

                            if($user->admin == 1) {
                                $_SESSION["admin"] = $user->admin ?? null;
                                header("Location: /admin");
                            } else {
                                header("Location: /appointment");
                            }
                        }
                    } else {
                        User::setAlert("error","User doesn't exist");
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("auth/login", [
                "alerts" => $alerts
            ]);
        }

        public static function logout() {
            session_start();

            $_SESSION = [];

            header("Location: /");
        }

        public static function forgot(Router $router) {

            $alerts = [];

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $auth = new User($_POST);
                $alerts = $auth->validateEmail();

                if(empty($alerts)) {
                    $user = User::where("email", $auth->email);

                    if($user && $user->confirmed === "1") {

                        // Generate a token

                        $user->createToken();
                        $user->save();

                        // Send the e-mail

                        $email = new Email($user->email, $user->name, $user->token);
                        $email->sendInstructions();

                        // Success alert

                        User::setAlert("success", "Check your e-mail");
                    } else {
                        User::setAlert("error", "User doesn't exist or account is not confirmed");
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("auth/forgot", [
                "alerts" => $alerts
            ]);
        }

        public static function recover(Router $router) {

            $alerts = [];
            $error = false;

            $token = esc($_GET["token"]);

            // Search user by their token

            $user = User::where("token", $token);

            if(empty($user)) {
                User::setAlert("error", "Token not valid");
                $error = true;
            }

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $password = new User($_POST);
                $alerts = $password->validatePassword();

                if(empty($alerts)) {
                    $user->password = null;

                    $user->password = $password->password;
                    $user->hashPassword();
                    $user->token = null;
                    $result = $user->save();

                    if($result) {
                        header("Location: /");
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("auth/recover", [
                "alerts" => $alerts,
                "error" => $error
            ]);
        }

        public static function create(Router $router) {

            $user = new User;
            $alerts = [];

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $user->synchronize($_POST);
                $alerts = $user->validateNewAccount();

                // Check that alerts is empty

                if(empty($alerts)) {

                    // Verify that the user is not registered already

                    $result = $user->userExists();

                    if($result->num_rows) {
                        $alerts = User::getAlerts();
                    } else {

                        // Hash the password

                        $user->hashPassword();

                        // Generate a unique token

                        $user->createToken();

                        // Send the email

                        $email = new Email($user->email, $user->name, $user->token);
                        $email->sendConfirmation();

                        // Create the user

                        $result = $user->save();

                        if($result) {
                            header("Location: /message");
                        }
                    }
                }
            }

            $router->render("auth/create-account", [
                "user" => $user,
                "alerts" => $alerts
            ]);
        }

        public static function message(Router $router) {
            $router->render("auth/message");
        }

        public static function confirm(Router $router) {
            
            $alerts = [];
            $token = esc($_GET["token"]);
            $user = User::where("token", $token);

            if(empty($user)) {

                // Show error message

                User::setAlert("error", "Invalid Token");
            } else {

                // Modify to confirmed user

                $user->confirmed = "1";
                $user->token = null;
                $user->save();
                User::setAlert("success", "Account Confirmed Successfully");
            }

            $alerts = User::getAlerts();

            $router->render("auth/confirm-account", [
                "alerts" => $alerts
            ]);
        }
    }
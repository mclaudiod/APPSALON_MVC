<?php

    namespace Classes;

    use PHPMailer\PHPMailer\PHPMailer;

    class Email {

        public $email;
        public $name;
        public $token;

        public function __construct($email, $name, $token) {
            $this->email = $email;
            $this->name = $name;
            $this->token = $token;
        }

        public function sendConfirmation() {

            // Create the object of email

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'a81614f8f52e02';
            $mail->Password = '0be6e339bebc45';

            $mail->setFrom("accounts@appsalon.com");
            $mail->addAddress("accounts@appsalon.com", "AppSalon.com");
            $mail->Subject = "Confirm your Account";

            // Set HTML

            $mail->isHTML(TRUE);
            $mail->CharSet = "UTF-8";
            
            $content = "<html>";
            $content .= "<p><strong>Hello " . $this->name . ".</strong> </p>";
            $content .= "<p>You have created an account on AppSalon.com, to confirm it you only have to click on this link: <a href='http://localhost:3000/confirm-account?token=" . $this->token . "'>Confirm Account</a></p>";
            $content .= "<p>If you didn't create an account in our site then you can safely ignore this email.</p>";
            $content .= "</html>";
            $mail->Body = $content;

            // Send Email

            $mail->send();
        }

        public function sendInstructions() {
            
            // Create the object of email

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'a81614f8f52e02';
            $mail->Password = '0be6e339bebc45';

            $mail->setFrom("accounts@appsalon.com");
            $mail->addAddress("accounts@appsalon.com", "AppSalon.com");
            $mail->Subject = "Recover your Password";

            // Set HTML

            $mail->isHTML(TRUE);
            $mail->CharSet = "UTF-8";
            
            $content = "<html>";
            $content .= "<p><strong>Hello " . $this->name . ".</strong> </p>";
            $content .= "<p>You have requested a password recovery on AppSalon.com, to recover it you only have to click on this link: <a href='http://localhost:3000/recover?token=" . $this->token . "'>Recover Password</a></p>";
            $content .= "<p>If you didn't ask for a password recovery in our site then you can safely ignore this email.</p>";
            $content .= "</html>";
            $mail->Body = $content;

            // Send Email

            $mail->send();
        }
    }
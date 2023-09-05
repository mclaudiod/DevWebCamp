<?php

    namespace Classes;

    use PHPMailer\PHPMailer\PHPMailer;

    class Email {
        protected $email;
        protected $name;
        protected $token;

        public function __construct($email, $name, $token) {
            $this->email = $email;
            $this->name = $name;
            $this->token = $token;
        }

        public function sendConfirmation() {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV["EMAIL_HOST"]; // 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV["EMAIL_PORT"]; // 2525;
            $mail->Username = $_ENV["EMAIL_USER"]; // 'a81614f8f52e02';
            $mail->Password = $_ENV["EMAIL_PASS"]; // '0be6e339bebc45';

            $mail->setFrom("accounts@debwebcamp.com");
            $mail->addAddress("accounts@debwebcamp.com", "debwebcamp.com");
            $mail->Subject = "Confirm your Account";
            
            $mail->isHTML(TRUE);
            $mail->CharSet = "UTF-8";

            $content = "<html>";
            $content .= "<p><strong> Hello " . $this->name . ".</strong> You have created an account in DebWebCamp, the only step left is to click on this link to confirm it: <a href='https://devwebcampphp.000webhostapp.com/confirmation?token=" . $this->token . "'>Confirm Account</a></p>";
            $content .= "<p>If you didn't create this account, you can safely ignore this email.</p>";
            $content .= "</html>";

            $mail->Body = $content;

            // Send Email

            $mail->send();
        }

        public function sendInstructions() {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'a81614f8f52e02';
            $mail->Password = '0be6e339bebc45';

            $mail->setFrom("accounts@debwebcamp.com");
            $mail->addAddress("accounts@debwebcamp.com", "debwebcamp.com");
            $mail->Subject = "Reset your Password";
            
            $mail->isHTML(TRUE);
            $mail->CharSet = "UTF-8";

            $content = "<html>";
            $content .= "<p><strong> Hello " . $this->name . ".</strong> You have forgotten your password, to reset it click on this link: <a href='https://devwebcampphp.000webhostapp.com/reset-password?token=" . $this->token . "'>Reset Password</a></p>";
            $content .= "<p>If you didn't ask for this, you can safely ignore this email.</p>";
            $content .= "</html>";

            $mail->Body = $content;

            // Send Email

            $mail->send();
        }
    }
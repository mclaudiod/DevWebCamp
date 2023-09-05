<?php

    namespace Controllers;

    use Classes\Email;
    use Model\User;
    use MVC\Router;

    class AuthController {
        public static function login(Router $router) {

            $alerts = [];

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $user = new User($_POST);
                $alerts = $user->validateLogIn();

                if(empty($alerts)) {

                    // Verify that the user exists

                    $user = User::where("email", $user->email);

                    if(!$user || !$user->confirmed) {
                        User::setAlert("error", "That user doesn't exist or is not confirmed");
                    } else {

                        if (password_verify($_POST["password"], $user->password)) {

                            // Log In

                            $_SESSION["id"] = $user->id;
                            $_SESSION["name"] = $user->name;
                            $_SESSION["surname"] = $user->surname;
                            $_SESSION["email"] = $user->email;
                            $_SESSION["admin"] = $user->admin ?? null;

                            // Redirection

                            if($user->admin) {
                                header("Location: /admin/dashboard");
                            } else {
                                header("Location: /finish-registration");
                            }

                        } else {
                            User::setAlert("error", "Incorrect Password");
                        }
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("auth/login", [
                "title" => "Log In",
                "alerts" => $alerts
            ]);
        }

        public static function logout() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_SESSION = [];
                header('Location: /');
            }
        }

        public static function create(Router $router) {
            $user = new User;
            $alerts = [];

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user->synchronize($_POST);
                $alerts = $user->validateNewAccount();

                if(empty($alerts)) {
                    $userExists = User::where("email", $user->email);

                    if($userExists) {
                        User::setAlert("error", "Your email is already registered");
                        $alerts = User::getAlerts();
                    } else {
                        // Hash the password

                        $user->hashPassword();

                        // Delete rpassword

                        unset($user->rpassword);

                        // Generate the token

                        $user->createToken();

                        // Create a new user

                        $result = $user->save();

                        // Send email

                        $email = new Email($user->email, $user->name, $user->token);
                        $email->sendConfirmation();

                        if($result) {
                            header("Location: /message");
                        }
                    }
                }
            }

            $router->render("auth/create-account", [
                "title" => "Create Account",
                "user" => $user,
                "alerts" => $alerts
            ]);
        }

        public static function forgot(Router $router) {
            $alerts = [];
            
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = new User($_POST);
                $alerts = $user->validateEmail();

                if(empty($alerts)) {

                    // Search the user

                    $user = User::where("email", $user->email);

                    if($user && $user->confirmed) {

                        // Generate a new token

                        $user->createToken();
                        unset($user->rpassword);

                        // Update the user

                        $user->save();

                        // Send the email

                        $email = new Email($user->email, $user->name, $user->token);
                        $email->sendInstructions();

                        // Show the alert

                        User::setAlert("success", "We sent the instructions to your email");
                    } else {
                        User::setAlert("error", "That user doesn't exist or is not confirmed");
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("auth/forgot-password", [
                "title" => "Forgot Password",
                "alerts" => $alerts
            ]);
        }

        public static function reset(Router $router) {
            $alerts = [];
            $token = esc($_GET["token"]);
            $validToken = true;
            if(!$token) header("Location: /");

            // Find the user with this token

            $user = User::where("token", $token);

            if(empty($user)) {
                User::setAlert("error", "Invalid Token");
                $validToken = false;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Add the new password

                $user->synchronize($_POST);

                // Validate password

                $alerts = $user->validatePassword();

                if(empty($alerts)) {

                    // Hash the password

                        $user->hashPassword();

                        // Delete rpassword and token

                        unset($user->rpassword);
                        $user->token = "";

                        // Update user

                        $result = $user->save();

                        if($result) {
                            header("Location: /login");
                        }
                }
            }

            $alerts = User::getAlerts();
            
            $router->render("auth/reset-password", [
                "title" => "Reset Password",
                "alerts" => $alerts,
                "validToken" => $validToken
            ]);
        }

        public static function message(Router $router) {
            $router->render("auth/message", [
                "title" => "Account Created Successfully"
            ]);
        }

        public static function confirmation(Router $router) {
            $token = esc($_GET["token"]);
            $alerts = [];

            if(!$token) header("Location: /");

            // Find the user with this token

            $user = User::where("token", $token);

            if(empty($user)) {
                User::setAlert("error", "Invalid Token");
            } else {
                
                // Confirm account

                $user->confirmed = 1;
                $user->token = "";
                unset($user->rpassword);
                
                // Save in the DB

                $user->save();

                User::setAlert("success", "Account confirmed successfully");
            }

            $alerts = User::getAlerts();

            $router->render("auth/confirmation", [
                "title" => "Account Confirmation",
                "alerts" => $alerts
            ]);
        }
    }
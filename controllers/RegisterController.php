<?php

    namespace Controllers;

    use Model\Categorie;
    use Model\Day;
    use Model\Event;
    use Model\EventsRegistrations;
    use Model\Gift;
    use Model\Hour;
    use Model\Package;
    use Model\Register;
    use Model\Speaker;
    use Model\User;
    use MVC\Router;

    class RegisterController {
        public static function create(Router $router) {

            if(!isAuth()) {
                header("Location: /login");
                return;
            }

            // Verify if the user is already registered

            $register = Register::where("user_id", $_SESSION["id"]);

            if(isset($register) && ($register->package_id === "3" || $register->package_id === "2")) {
                header("Location: /ticket?id=" . urlencode($register->token));
                return;
            }

            if(isset($register) && $register->package_id === "1") {
                header("Location: /finish-registration/conferences");
                return;
            }

            $router->render("register/create", [
                "title" => "Finish Registration"
            ]);
        }

        public static function free() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                if(!isAuth()) {
                    header("Location: /login");
                    return;
                }

                $register = Register::where("user_id", $_SESSION["id"]);

                if(isset($register) && $register->package_id === "3") {
                    header("Location: /ticket?id=" . urlencode($register->token));
                }

                $token = substr(md5(uniqid(rand(), true)), 0, 8);

                // Create register

                $data = [
                    "package_id" => 3,
                    "payment_id" => "",
                    "token" => $token,
                    "user_id" => $_SESSION["id"]
                ];

                $register = new Register($data);
                $result = $register->save();

                if($result) {
                    header("Location: /ticket?id=" . urlencode($register->token));
                };
            }
        }

        public static function ticket(Router $router) {

            // Validate the URL

            $id = $_GET['id'];

            if(!$id || !strlen($id) === 8) {
                header('Location: /');
                return;
            }

            // Search for it in the DB

            $register = Register::where('token', $id);

            if(!$register) {
                header('Location: /');
                return;
            }

            // Fill the reference tables

            $register->user = User::find($register->user_id);
            $register->package = Package::find($register->package_id);

            $router->render("register/ticket", [
                "title" => "DevWebCamp Attendance",
                "register" => $register
            ]);
        }

        public static function pay() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                if(!isAuth()) {
                    header("Location: /login");
                    return;
                }

                // Validate that Post doesn't come empty

                if(empty($_POST)) {
                    echo json_encode([]);
                    return;
                }

                // Create register

                $data = $_POST;
                $data["token"] = substr(md5(uniqid(rand(), true)), 0, 8);
                $data["user_id"] = $_SESSION["id"];
                
                try {
                    $register = new Register($data);
                    $result = $register->save();
                    echo json_encode($result);
                } catch (\Throwable $th) {
                    echo json_encode([
                        "result" => "error"
                    ]);
                }
            }
        }

        public static function conferences(Router $router) {
            
            if(!isAuth()) {
                header("Location: /login");
                return;
            }
            
            // Validate that the user has the presential package

            $register = Register::where("user_id", $_SESSION["id"]);

            if(isset($register) && $register->package_id === "2") {
                header("Location: /ticket?id=" . urlencode($register->token));
                return;
            }

            if($register->package_id !== "1") {
                header("Location: /");
                return;
            }

            // Redirection to virtual ticket in case of having finished registration

            if(isset($register->gift_id) && $register->package_id === "1") {
                header("Location: /ticket?id=" . urlencode($register->token));
            }

            $events = Event::order("hour_id", "ASC");
            $formattedEvents = [];

            foreach($events as $event) {
                $event->categorie = Categorie::find($event->categorie_id);
                $event->day = Day::find($event->day_id);
                $event->hour = Hour::find($event->hour_id);
                $event->speaker = Speaker::find($event->speaker_id);

                if($event->day_id === "1" && $event->categorie_id === "1") {
                    $formattedEvents["conferences_f"][] = $event;
                }

                if($event->day_id === "2" && $event->categorie_id === "1") {
                    $formattedEvents["conferences_s"][] = $event;
                }

                if($event->day_id === "1" && $event->categorie_id === "2") {
                    $formattedEvents["workshops_f"][] = $event;
                }

                if($event->day_id === "2" && $event->categorie_id === "2") {
                    $formattedEvents["workshops_s"][] = $event;
                }
            }

            $gifts = Gift::all("ASC");

            // Handling the registration using $_POST

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                
                // Check if the user is authenticated

                if(!isAuth()) {
                    header("Location: /login");
                }

                $events = explode(",", $_POST["events"]);

                if(empty($events)) {
                    echo json_encode(["result" => false]);
                    return;
                }

                // Obtain user register

                $register = Register::where("user_id", $_SESSION["id"]);

                if(!isset($register) || $register->package_id !== "1") {
                    echo json_encode(["result" => false]);
                    return;
                }

                $eventsArray = [];

                // Validate the availability of the selected events

                foreach($events as $event_id) {
                    $event = Event::find($event_id);

                    // Check that the event exists

                    if(!isset($event) || $event->seats === "0") {
                        echo json_encode(["result" => false]);
                        return;
                    }

                    $eventsArray[] = $event;
                }

                foreach($eventsArray as $event) {
                    $event->seats -= 1;
                    $event->save();

                    // Save the register

                    $data = [
                        "event_id" => (int) $event->id,
                        "registration_id" => (int) $register->id
                    ];

                    $userRegistration = new EventsRegistrations($data);
                    $userRegistration->save();
                }

                // Save the gift

                $register->synchronize(["gift_id" => $_POST["gift_id"]]);
                $result = $register->save();

                if($result) {
                    echo json_encode([
                        "result" => $result,
                        "token" => $register->token
                    ]);
                } else {
                    echo json_encode(["result" => false]);
                }

                return;
            }

            $router->render("register/conferences", [
                "title" => "Choose Workshops and Conferences",
                "events" => $formattedEvents,
                "gifts" => $gifts
            ]);
        }
    }
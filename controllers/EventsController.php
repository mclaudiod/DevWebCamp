<?php

    namespace Controllers;

    use Classes\Pagination;
    use Model\Categorie;
    use Model\Day;
    use Model\Event;
    use Model\Hour;
    use Model\Speaker;
    use MVC\Router;

    class EventsController {
        public static function index(Router $router) {

            if(!isAdmin()) {
                header("Location: /login");
            }

            $currentPage = $_GET["page"] ?? 1;
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT) ?? 1;

            if(!$currentPage || $currentPage < 1) {
                header("Location: /admin/events?page=1");
            }

            $registriesPerPage = 10;
            
            $totalRegistries = Event::total();

            $pagination = new Pagination($currentPage, $registriesPerPage, $totalRegistries);

            if($pagination->totalPages() < $currentPage) {
                header("Location: /admin/events?page=1");
            }

            $events = Event::paginate($registriesPerPage, $pagination->offset());

            foreach($events as $event) {
                $event->categorie = Categorie::find($event->categorie_id);
                $event->day = Day::find($event->day_id);
                $event->hour = Hour::find($event->hour_id);
                $event->speaker = Speaker::find($event->speaker_id);
            }

            $router->render("admin/events/index", [
                "title" => "Conferences and Workshops",
                "events" => $events,
                "pagination" => $pagination->pagination()
            ]);
        }

        public static function create(Router $router) {
            $alerts = [];

            if(!isAdmin()) {
                header("Location: /login");
            }

            $categories = Categorie::all("ASC");
            $days = Day::all("ASC");
            $hours = Hour::all("ASC");

            $event = new Event();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!isAdmin()) {
                    header("Location: /login");
                }

                $event->synchronize($_POST);

                $alerts = $event->validate();

                if(empty($alerts)) {
                    $result = $event->save();

                    if($result) {
                        header("Location: /admin/events");
                    }
                }
            }

            $router->render("admin/events/create", [
                "title" => "Add Event",
                "alerts" => $alerts,
                "categories" => $categories,
                "days" => $days,
                "hours" => $hours,
                "event" => $event
            ]);
        }

        public static function edit(Router $router) {
            $alerts = [];

            if(!isAdmin()) {
                header("Location: /login");
            }

            // Validate the id

            $id = $_GET["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if(!$id) {
                header("Location: /admin/events");
            }
            
            $categories = Categorie::all("ASC");
            $days = Day::all("ASC");
            $hours = Hour::all("ASC");

            // Get event to edit

            $event = Event::find($id);

            if(!$event) {
                header("Location: /admin/events");
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(!isAdmin()) {
                    header("Location: /login");
                }

                $event->synchronize($_POST);

                $alerts = $event->validate();

                if(empty($alerts)) {
                    $result = $event->save();

                    if($result) {
                        header("Location: /admin/events");
                    }
                }
            }

            $router->render("admin/events/edit", [
                "title" => "Edit Event",
                "alerts" => $alerts,
                "categories" => $categories,
                "days" => $days,
                "hours" => $hours,
                "event" => $event
            ]);
        }

        public static function delete() {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!isAdmin()) {
                    header("Location: /login");
                }

                // Validate the id

                $id = $_POST["id"];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if(!$id) {
                    header("Location: /admin/events");
                }
                
                // Get event to delete
    
                $event = Event::find($id);
    
                if(!isset($event)) {
                    header("Location: /admin/events");
                }

                $result = $event->delete();

                if($result) {
                    header("Location: /admin/events");
                }
            }
        }
    }
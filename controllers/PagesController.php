<?php

    namespace Controllers;

    use Model\Categorie;
    use Model\Day;
    use Model\Event;
    use Model\Hour;
    use Model\Speaker;
    use MVC\Router;

    class PagesController {
        public static function index(Router $router) {
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

            // Obtain the total of each block

            $speakersTotal = Speaker::total();
            $conferences = Event::total("categorie_id", 1);
            $workshops = Event::total("categorie_id", 2);

            // Obtain all the speakers

            $speakers = Speaker::all();


            $router->render("pages/index", [
                "title" => "Home",
                "events" => $formattedEvents,
                "speakersTotal" => $speakersTotal,
                "conferences" => $conferences,
                "workshops" => $workshops,
                "speakers" => $speakers
            ]);
        }

        public static function event(Router $router) {
            $router->render("pages/devwebcamp", [
                "title" => "About WebDevCamp"
            ]);
        }

        public static function packages(Router $router) {
            $router->render("pages/packages", [
                "title" => "Packages WebDevCamp"
            ]);
        }

        public static function conferences(Router $router) {

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

            $router->render("pages/conferences", [
                "title" => "Conferences and Workshops",
                "events" => $formattedEvents
            ]);
        }

        public static function error(Router $router) {
            $router->render("pages/error", [
                "title" => "Page Not Found"
            ]);
        }
    }
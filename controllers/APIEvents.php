<?php

    namespace Controllers;

    use Model\EventSchedule;

    class APIEvents {
        public static function index() {
            $day_id = $_GET["day_id"] ?? "";
            $categorie_id = $_GET["categorie_id"] ?? "";

            $day_id = filter_var($day_id, FILTER_VALIDATE_INT);
            $categorie_id = filter_var($categorie_id, FILTER_VALIDATE_INT);

            if(!$day_id || !$categorie_id) {
                echo json_encode([]);
                return;
            }

            $events = EventSchedule::whereArray(["day_id" => $day_id, "categorie_id" => $categorie_id]) ?? [];

            echo json_encode($events);
        }
    }
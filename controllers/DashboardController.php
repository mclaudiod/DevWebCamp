<?php

    namespace Controllers;

use Model\Event;
use Model\Register;
use Model\User;
use MVC\Router;

    class DashboardController {
        public static function index(Router $router) {

            if(!isAdmin()) {
                header("Location: /login");
            }

            // Obtain last registers

            $registers = Register::get(5);

            foreach($registers as $register) {
                $register->user = User::find($register->user_id);

            }

            // Calculate the income

            $virtuals = Register::total("package_id", 2);
            $presentials = Register::total("package_id", 1);

            $income = ($virtuals * 46.41) + ($presentials * 189.54);

            // Obtain events with less and most available seats

            $lessSeats = Event::orderQuantity("seats", "ASC", 5);
            $mostSeats = Event::orderQuantity("seats", "DESC", 5);
            
            $router->render("admin/dashboard/index", [
                "title" => "Administration Panel",
                "registers" => $registers,
                "income" => $income,
                "lessSeats" => $lessSeats,
                "mostSeats" => $mostSeats
            ]);
        }
    }
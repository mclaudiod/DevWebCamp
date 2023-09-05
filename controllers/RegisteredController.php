<?php

    namespace Controllers;

    use Classes\Pagination;
use Model\Package;
use Model\Register;
use Model\User;
use MVC\Router;

    class RegisteredController {
        public static function index(Router $router) {

            if(!isAdmin()) {
                header("Location: /login");
            }

            $currentPage = $_GET["page"] ?? 1;
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT) ?? 1;
            
            if(!$currentPage || $currentPage < 1) {
                header("Location: /admin/registered?page=1");
            }

            $registriesPerPage = 30;
            
            $totalRegistries = Register::total();

            $pagination = new Pagination($currentPage, $registriesPerPage, $totalRegistries);

            if($pagination->totalPages() < $currentPage) {
                header("Location: /admin/registered?page=1");
            }

            $registers = Register::paginate($registriesPerPage, $pagination->offset());

            foreach($registers as $register) {
                $register->user = User::find($register->user_id);
                $register->package = Package::find($register->package_id);
            }

            $router->render("admin/registered/index", [
                "title" => "Registered Users",
                "registers" => $registers,
                "pagination" => $pagination->pagination()
            ]);
        }
    }
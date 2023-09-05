<?php

    function debug($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;
    };

    // Escape/Sanitize HTML

    function esc($html) : string {
        $esc = htmlspecialchars($html);
        return $esc;
    };

    // Function that checks if the user is authenticated

    function isAuth() : bool {
        return isset($_SESSION["name"]) && !empty($_SESSION);
    };

    // Function that checks if the user is an admin

    function isAdmin() : bool {
        return isset($_SESSION["admin"]) && !empty($_SESSION["admin"]);
    };

    function currentPage($path) : bool {
        return str_contains(isset($_SERVER['PATH_INFO']) ? str_replace("/public_html", "", $_SERVER['PATH_INFO']) : '/', $path) ? true : false;
    };

    function aos_animacion() : void {
        $efects = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
        $efect = array_rand($efects, 1);
        echo ' data-aos="' . $efects[$efect] . '" ';
    };
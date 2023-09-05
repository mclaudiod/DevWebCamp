<?php

    namespace Model;

    use Model\ActiveRecord;

    class Speaker extends ActiveRecord {
        protected static $table = "speakers";
        protected static $dbColumns = ["id", "name", "surname", "city", "country", "img", "tags", "networks"];
        
        public $id;
        public $name;
        public $surname;
        public $city;
        public $country;
        public $img;
        public $tags;
        public $networks;
        
        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->surname = $args["surname"] ?? "";
            $this->city = $args["city"] ?? "";
            $this->country = $args["country"] ?? "";
            $this->img = $args["img"] ?? "";
            $this->tags = $args["tags"] ?? "";
            $this->networks = $args["networks"] ?? "";
        }

        public function validate() {
            if(!$this->name) {
                self::$alerts["error"][] = "The name is required";
            }

            if(!$this->surname) {
                self::$alerts["error"][] = "The surname is required";
            }

            if(!$this->city) {
                self::$alerts["error"][] = "The city is required";
            }

            if(!$this->country) {
                self::$alerts["error"][] = "The country is required";
            }

            if(!$this->img) {
                self::$alerts["error"][] = "The image is required";
            }

            if(!$this->tags) {
                self::$alerts["error"][] = "The areas of expertise are required";
            }
        
            return self::$alerts;
        }
    }
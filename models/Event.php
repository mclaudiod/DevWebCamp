<?php

    namespace Model;

    use Model\ActiveRecord;

    class Event extends ActiveRecord {
        protected static $table = "events";
        protected static $dbColumns = ["id", "name", "description", "seats", "categorie_id", "day_id", "hour_id", "speaker_id"];
        
        public $id;
        public $name;
        public $description;
        public $seats;
        public $categorie_id;
        public $day_id;
        public $hour_id;
        public $speaker_id;
        
        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->description = $args["description"] ?? "";
            $this->seats = $args["seats"] ?? "";
            $this->categorie_id = $args["categorie_id"] ?? "";
            $this->day_id = $args["day_id"] ?? "";
            $this->hour_id = $args["hour_id"] ?? "";
            $this->speaker_id = $args["speaker_id"] ?? "";
        }

        public function validate() {
            if(!$this->name) {
                self::$alerts["error"][] = "The name is required";
            }

            if(!$this->description) {
                self::$alerts["error"][] = "The description is required";
            }

            if(!$this->categorie_id || !filter_var($this->categorie_id, FILTER_VALIDATE_INT)) {
                self::$alerts["error"][] = "The categorie is required";
            }

            if(!$this->day_id || !filter_var($this->day_id, FILTER_VALIDATE_INT)) {
                self::$alerts["error"][] = "The day is required";
            }

            if(!$this->hour_id || !filter_var($this->hour_id, FILTER_VALIDATE_INT)) {
                self::$alerts["error"][] = "The time is required";
            }

            if(!$this->speaker_id || !filter_var($this->speaker_id, FILTER_VALIDATE_INT)) {
                self::$alerts["error"][] = "The speaker is required";
            }
        
            return self::$alerts;
        }
    }